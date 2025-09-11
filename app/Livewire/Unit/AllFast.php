<?php

namespace App\Livewire\Unit;

use App\Models\Audit;
use App\Models\Draft;
use App\Models\Notification;
use App\Models\Vessel as ModelsVessel;
use App\Models\Voyage;
use Illuminate\Support\Facades\Auth;
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

        $this->loadDraft();

        if (empty($this->robs)) {
            $this->addRow();
        }
    }

    public function autoSave()
    {
        $this->saveDraftToDatabase();
    }

    private function saveDraftToDatabase()
    {
        Draft::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'type' => 'all_fast',
            ],
            [
                'data' => json_encode($this->only([
                    'voyage_no',
                    'all_fast_datetime',
                    'port',
                    'remarks',
                    'master_info',
                    'gmt_offset',
                    'robs',
                ])),
            ]
        );

        $this->dispatch('draftSaved');
    }

    public function addRow()
    {
        $this->robs[] = [
            'hsfo' => null,
            'biofuel' => null,
            'vlsfo' => null,
            'lsmgo' => null,
        ];
        $this->saveDraftToDatabase();
    }

    public function removeRow($index)
    {
        unset($this->robs[$index]);
        $this->robs = array_values($this->robs);
        $this->saveDraftToDatabase();
    }

    public function loadDraft()
    {
        $draft = Draft::where('user_id', Auth::id())
            ->where('type', 'all_fast')
            ->first();

        if ($draft) {
            $data = json_decode($draft->data, true);

            $this->voyage_no = $data['voyage_no'] ?? null;
            $this->all_fast_datetime = $data['all_fast_datetime'] ?? null;
            $this->port = $data['port'] ?? null;
            $this->remarks = $data['remarks'] ?? null;
            $this->master_info = $data['master_info'] ?? null;
            $this->gmt_offset = $data['gmt_offset'] ?? null;
            $this->robs = $data['robs'] ?? [];
        }
    }

    public function clearDraft()
    {
        Draft::where('user_id', Auth::id())
            ->where('type', 'all_fast')
            ->delete();
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

        $vessel = ModelsVessel::findOrFail($this->vessel_id);

        if (!$vessel->is_active) {
            Toaster::error('This vessel has been deactivated. It will no longer be available for new reports.');
            return;
        }

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
            'vessel_id' => $voyage->vessel_id,
            'text'      => "{$voyage->report_type} report has been created.",
        ]);

        foreach ($this->robs as $rob) {
            $voyage->robs()->create($rob);
        }

        $voyage->remarks()->create(['remarks' => $this->remarks]);
        $voyage->master_info()->create(['master_info' => $this->master_info]);

        Audit::create([
            'user'          => Auth::user()->name,
            'event'          => 'created_all_fast_report',
            'old_values'     => [],
            'new_values'     => [
                'report_type' => $voyage->report_type,
            ],
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
        ]);

        ModelsVessel::where('id', $voyage->vessel_id)->increment('has_reports');

        $this->clearDraft();
        $this->clearForm();
        Toaster::success('All Fast Report Created Successfully.');
        $this->redirect(TableAllFastReport::class);
    }

    public function clearForm()
    {
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
