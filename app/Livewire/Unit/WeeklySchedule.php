<?php

namespace App\Livewire\Unit;

use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use App\Models\Voyage;

class WeeklySchedule extends Component
{
    public $vessel_id;
    public $voyage_no;
    public $all_fast_datetime; // all_fast_datetime as date here
    public $ports = [];

    public $master_info;

    public $vesselName = null;

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

        $this->addPort();
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
        $this->clearForm();
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
    }

    public function removePort($index)
    {
        unset($this->ports[$index]);
        $this->ports = array_values($this->ports);
    }

    public function removeAgent($portIndex, $agentIndex)
    {
        unset($this->ports[$portIndex]['agents'][$agentIndex]);
        $this->ports[$portIndex]['agents'] = array_values($this->ports[$portIndex]['agents']);
    }

    public function addAgent($portIndex)
    {
        $this->ports[$portIndex]['agents'][] = ['name' => '', 'address' => '', 'pic_name' => '', 'telephone' => '', 'mobile' => '', 'email' => ''];
    }

    public function clearForm()
    {
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
