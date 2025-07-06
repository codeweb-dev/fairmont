<?php

namespace App\Livewire\Unit;

use App\Models\Notification;
use App\Models\User;
use App\Models\Voyage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class AllFast extends Component
{
    public array $robs = [];

    public $vessel_id;
    public $voyage_no;
    public $all_fast_datetime;
    public $port;
    public $gmt_offset;

    public $remarks;
    public $master_info;

    public $vesselName = null;
    public array $gmtOffsets = [
        "GMT-12:00",
        "GMT-11:00",
        "GMT-10:00",
        "GMT-09:30",
        "GMT-09:00",
        "GMT-08:00",
        "GMT-07:00",
        "GMT-06:00",
        "GMT-05:00",
        "GMT-04:30",
        "GMT-04:00",
        "GMT-03:30",
        "GMT-03:00",
        "GMT-02:30",
        "GMT-02:00",
        "GMT-01:00",
        "GMT",
        "GMT+01:00",
        "GMT+02:00",
        "GMT+02:30",
        "GMT+03:00",
        "GMT+03:30",
        "GMT+04:00",
        "GMT+04:30",
        "GMT+05:00",
        "GMT+05:30",
        "GMT+06:00",
        "GMT+06:30",
        "GMT+07:00",
        "GMT+08:00",
        "GMT+09:00",
        "GMT+09:30",
        "GMT+10:00",
        "GMT+10:30",
        "GMT+11:00",
        "GMT+11:30",
        "GMT+12:00",
        "GMT+12:45",
        "GMT+13:00",
        "GMT+13:45",
        "GMT+14:00",
    ];

    protected $listeners = ['saveDraft'];

    public function mount()
    {
        $user = Auth::user();
        $vessel = $user->vessels()->first();

        if ($vessel) {
            $this->vessel_id = $vessel->id;
            $this->vesselName = $vessel->name;
        } else {
            return redirect()->route('unassigned');
        }

        // Load draft data if exists
        $this->loadDraft();

        // If no draft or no robs, add default row
        if (empty($this->robs)) {
            $this->addRow();
        }
    }

    public function updated($propertyName)
    {
        // Auto-save draft whenever any property is updated
        $this->saveDraft();
    }

    public function addRow()
    {
        $this->robs[] = [
            'hsfo' => null,
            'biofuel' => null,
            'vlsfo' => null,
            'lsmgo' => null,
        ];
        $this->saveDraft();
    }

    public function removeRow($index)
    {
        unset($this->robs[$index]);
        $this->robs = array_values($this->robs);
        $this->saveDraft();
    }

    public function saveDraft()
    {
        $draftData = [
            'voyage_no' => $this->voyage_no,
            'all_fast_datetime' => $this->all_fast_datetime,
            'master_info' => $this->master_info,
            'remarks' => $this->remarks,
            'port' => $this->port,
            'gmt_offset' => $this->gmt_offset,
            'robs' => $this->robs,
            'saved_at' => now()->toDateTimeString(),
        ];

        Session::put('all_fast_draft_' . Auth::id(), $draftData);
    }

    public function loadDraft()
    {
        $draftKey = 'all_fast_draft_' . Auth::id();
        $draft = Session::get($draftKey);

        if ($draft) {
            $this->voyage_no = $draft['voyage_no'] ?? null;
            $this->all_fast_datetime = $draft['all_fast_datetime'] ?? null;
            $this->port = $draft['port'] ?? null;
            $this->remarks = $draft['remarks'] ?? null;
            $this->master_info = $draft['master_info'] ?? null;
            $this->gmt_offset = $draft['gmt_offset'] ?? null;
            $this->robs = $draft['robs'] ?? [];
        }
    }

    public function clearDraft()
    {
        $draftKey = 'all_fast_draft_' . Auth::id();
        Session::forget($draftKey);
    }

    public function save()
    {
        $this->validate([
            'vessel_id' => 'required|exists:vessels,id',
            'voyage_no' => 'required|string|max:50',
            'all_fast_datetime' => 'required|date',
            'port' => 'required|string',
            'gmt_offset' => 'required|string',
            'master_info' => 'nullable|string|max:5000',
            'remarks' => 'nullable|string|max:5000',
        ]);

        $voyage = Voyage::create([
            'vessel_id' => $this->vessel_id,
            'unit_id' => Auth::id(),
            'report_type' => 'All Fast',
            'voyage_no' => $this->voyage_no,
            'all_fast_datetime' => $this->all_fast_datetime,
            'port' => $this->port,
            'gmt_offset' => $this->gmt_offset,
        ]);

        Notification::create([
            'text' => "{$voyage->report_type} report has been created.",
        ]);

        foreach ($this->robs as $rob) {
            $voyage->robs()->create($rob);
        }

        $voyage->remarks()->create(['remarks' => $this->remarks]);
        $voyage->master_info()->create(['master_info' => $this->master_info]);

        // Clear draft after successful save
        $this->clearDraft();

        Toaster::success('All Fast Report Created Successfully.');
        $this->clearForm();

        $this->redirect('/table-all-fast-report');
    }

    public function clearForm()
    {
        // Clear the draft when form is cleared
        $this->clearDraft();

        $this->reset([
            'voyage_no',
            'all_fast_datetime',
            'port',
            'gmt_offset',
            'robs',
            'remarks',
            'master_info',
        ]);
        $this->addRow();
    }

    public function render()
    {
        return view('livewire.unit.all-fast');
    }
}
