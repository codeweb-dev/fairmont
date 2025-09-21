<?php

namespace App\Livewire\Unit;

use App\Models\Audit;
use App\Models\Notification;
use App\Models\Voyage;
use App\Models\Vessel as ModelsVessel;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;

class EditWeeklyScheduleReport extends Component
{
    public $voyageId;
    public $vessel_id;
    public $voyage_no;
    public $all_fast_datetime;
    public $ports = [];
    public $remarks;
    public $master_info;
    public $vesselName;

    public function mount($id)
    {
        $voyage = Voyage::with(['vessel', 'ports.agents', 'remarks', 'master_info'])
            ->findOrFail($id);

        $this->voyageId = $voyage->id;
        $this->vessel_id = $voyage->vessel_id;
        $this->voyage_no = $voyage->voyage_no;
        $this->all_fast_datetime = $voyage->all_fast_datetime;
        $this->remarks = $voyage->remarks->remarks ?? null;
        $this->master_info = $voyage->master_info->master_info ?? null;
        $this->ports = $voyage->ports->map(function ($port) {
            return [
                'port'      => $port->port,
                'activity'  => $port->activity,
                'eta_etb'   => $port->eta_etb,
                'etcd'      => $port->etcd,
                'cargo'     => $port->cargo,
                'cargo_qty' => $port->cargo_qty,
                'remarks'   => $port->remarks,
                'agents'    => $port->agents->map(function ($agent) {
                    return [
                        'name'      => $agent->name,
                        'address'   => $agent->address,
                        'pic_name'  => $agent->pic_name,
                        'telephone' => $agent->telephone,
                        'mobile'    => $agent->mobile,
                        'email'     => $agent->email,
                    ];
                })->toArray(),
            ];
        })->toArray();

        $this->vesselName = $voyage->vessel->name ?? '';
    }

    public function update()
    {
        $this->validate([
            'voyage_no' => 'required|string',
            'all_fast_datetime' => 'required|date',
            'master_info' => 'nullable|string|max:5000',
            'remarks' => 'nullable|string|max:5000',
        ]);

        $voyage = Voyage::findOrFail($this->voyageId);

        $oldValues = $voyage->toArray();

        $voyage->update([
            'voyage_no' => $this->voyage_no,
            'all_fast_datetime' => $this->all_fast_datetime,
        ]);

        // Delete old ports & agents then re-create
        $voyage->ports()->delete();
        foreach ($this->ports as $portData) {
            $port = $voyage->ports()->create($portData);
            foreach ($portData['agents'] as $agentData) {
                $port->agents()->create($agentData);
            }
        }

        // Update remarks & master info
        $voyage->remarks()->updateOrCreate([], ['remarks' => $this->remarks]);
        $voyage->master_info()->updateOrCreate([], ['master_info' => $this->master_info]);

        // Notification
        Notification::create([
            'vessel_id' => $voyage->vessel_id,
            'text'      => "{$voyage->report_type} report has been updated.",
        ]);

        // Audit
        Audit::create([
            'user'       => Auth::user()->name,
            'event'      => 'updated_weekly_schedule_report',
            'old_values' => $oldValues,
            'new_values' => $voyage->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Toaster::success('Weekly Schedule Report Updated Successfully.');

        return redirect()->route('table-weekly-schedule-report');
    }

    public function addPort()
    {
        $this->ports[] = [
            'port' => '',
            'activity' => '',
            'eta_etb' => null,
            'etcd' => null,
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

    public function addAgent($portIndex)
    {
        $this->ports[$portIndex]['agents'][] =
            ['name' => '', 'address' => '', 'pic_name' => '', 'telephone' => '', 'mobile' => '', 'email' => ''];
    }

    public function removeAgent($portIndex, $agentIndex)
    {
        unset($this->ports[$portIndex]['agents'][$agentIndex]);
        $this->ports[$portIndex]['agents'] = array_values($this->ports[$portIndex]['agents']);
    }

    public function render()
    {
        return view('livewire.unit.edit-weekly-schedule-report');
    }
}
