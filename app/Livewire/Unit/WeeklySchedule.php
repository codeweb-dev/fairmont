<?php

namespace App\Livewire\Unit;

use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use App\Models\Voyage;
use Illuminate\Support\Facades\Session;

class WeeklySchedule extends Component
{
    public $vessel_id;
    public $voyage_no;
    public $all_fast_datetime; // all_fast_datetime as date here
    public $ports = [];

    public $master_info;

    public $vesselName = null;
    protected $listeners = ['saveDraft'];

    public function updated($propertyName)
    {
        $this->saveDraft(); // Auto-save on update
    }

    public function saveDraft()
    {
        $draftData = [
            'voyage_no' => $this->voyage_no,
            'all_fast_datetime' => $this->all_fast_datetime,
            'master_info' => $this->master_info,
            'ports' => $this->ports,
            'saved_at' => now()->toDateTimeString(),
        ];

        Session::put('weekly_schedule_draft_' . Auth::id(), $draftData);
    }

    public function loadDraft()
    {
        $draftKey = 'weekly_schedule_draft_' . Auth::id();
        $draft = Session::get($draftKey);

        if ($draft) {
            $this->voyage_no = $draft['voyage_no'] ?? null;
            $this->all_fast_datetime = $draft['all_fast_datetime'] ?? null;
            $this->master_info = $draft['master_info'] ?? null;
            $this->ports = $draft['ports'] ?? [];
        }
    }

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

        if (empty($this->ports)) {
            $this->addPort();
        }
    }

    public function save()
    {
        $this->validate([
            'vessel_id' => 'required|exists:vessels,id',
            'voyage_no' => 'required|string',
            'all_fast_datetime' => 'required|date',
            'master_info' => 'nullable|string|max:5000',
        ]);

        $voyage = Voyage::create([
            'vessel_id' => $this->vessel_id,
            'unit_id' => Auth::id(),
            'report_type' => 'Weekly Schedule',
            'voyage_no' => $this->voyage_no,
            'all_fast_datetime' => $this->all_fast_datetime,
        ]);

        Notification::create([
            'text' => "{$voyage->report_type} report has been created.",
        ]);

        foreach ($this->ports as $portData) {
            $port = $voyage->ports()->create($portData);

            foreach ($portData['agents'] as $agentData) {
                $port->agents()->create($agentData);
            }
        }

        Toaster::success('Weekly Schedule Created Successfully.');
        $voyage->master_info()->create(['master_info' => $this->master_info]);
        $this->clearDraft();
        $this->clearForm();

        $this->redirect('/table-weekly-schedule-report');
    }

    public function addPort()
    {
        $this->ports[] = [
            'port' => '',
            'activity' => '',
            'eta_etb' => '',
            'etcd' => '',
            'cargo' => '',
            'cargo_qty' => '',
            'remarks' => '',
            'agents' => [
                ['name' => '', 'address' => '', 'pic_name' => '', 'telephone' => '', 'mobile' => '', 'email' => '']
            ]
        ];

        $this->saveDraft();
    }

    public function removePort($index)
    {
        unset($this->ports[$index]);
        $this->ports = array_values($this->ports);
        $this->saveDraft();
    }

    public function removeAgent($portIndex, $agentIndex)
    {
        unset($this->ports[$portIndex]['agents'][$agentIndex]);
        $this->ports[$portIndex]['agents'] = array_values($this->ports[$portIndex]['agents']);
        $this->saveDraft();
    }

    public function addAgent($portIndex)
    {
        $this->ports[$portIndex]['agents'][] = ['name' => '', 'address' => '', 'pic_name' => '', 'telephone' => '', 'mobile' => '', 'email' => ''];
        $this->saveDraft();
    }

    public function clearDraft()
    {
        $draftKey = 'weekly_schedule_draft_' . Auth::id();
        Session::forget($draftKey);
    }

    public function clearForm()
    {
        $this->clearDraft();

        $this->reset([
            'voyage_no',
            'all_fast_datetime',
            'master_info',
            'ports',
        ]);

        $this->addPort();
    }

    public function render()
    {
        return view('livewire.unit.weekly-schedule');
    }
}
