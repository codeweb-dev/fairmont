<?php

namespace App\Livewire\Unit;

use App\Models\Audit;
use App\Models\Notification;
use App\Models\Voyage;
use App\Models\Vessel as ModelsVessel;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;

class EditPortOfCallReport extends Component
{
    public $voyageId;

    // Vessel & Voyage fields
    public $vessel_id;
    public $vesselName;
    public $voyage_no;
    public $call_sign;
    public $flag;
    public $port_of_registry;
    public $official_number;
    public $imo_number;
    public $class_society;
    public $class_no;
    public $pi_club;
    public $loa;
    public $lbp;
    public $breadth_extreme;
    public $depth_moulded;
    public $height_maximum;
    public $bridge_front_bow;
    public $bridge_front_stern;
    public $light_ship_displacement;
    public $keel_laid;
    public $launched;
    public $delivered;
    public $shipyard;

    public $ports = [];
    public $remarks;
    public $master_info;

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

    public function mount($id)
    {
        $this->voyageId = $id;
        $this->loadVoyage();
    }

    private function loadVoyage()
    {
        $voyage = Voyage::with(['vessel', 'ports.agents', 'remarks', 'master_info'])
            ->findOrFail($this->voyageId);

        $this->vessel_id   = $voyage->vessel_id;
        $this->vesselName  = $voyage->vessel->name ?? '';
        $this->voyage_no   = $voyage->voyage_no;
        $this->remarks     = optional($voyage->remarks)->remarks;
        $this->master_info = optional($voyage->master_info)->master_info;

        $this->call_sign   = $voyage->call_sign;
        $this->flag        = $voyage->flag;
        $this->port_of_registry = $voyage->port_of_registry;
        $this->official_number  = $voyage->official_number;
        $this->imo_number  = $voyage->imo_number;
        $this->class_society    = $voyage->class_society;
        $this->class_no    = $voyage->class_no;
        $this->pi_club     = $voyage->pi_club;
        $this->loa         = $voyage->loa;
        $this->lbp         = $voyage->lbp;
        $this->breadth_extreme = $voyage->breadth_extreme;
        $this->depth_moulded   = $voyage->depth_moulded;
        $this->height_maximum  = $voyage->height_maximum;
        $this->bridge_front_bow   = $voyage->bridge_front_bow;
        $this->bridge_front_stern = $voyage->bridge_front_stern;
        $this->light_ship_displacement = $voyage->light_ship_displacement;
        $this->keel_laid    = $voyage->keel_laid;
        $this->launched     = $voyage->launched;
        $this->delivered    = $voyage->delivered;
        $this->shipyard     = $voyage->shipyard;

        // Transform ports + agents to array
        $this->ports = $voyage->ports->map(function ($port) {
            return [
                'id'         => $port->id,
                'voyage_no'  => $port->voyage_no,
                'cargo'      => $port->cargo,
                'charterers' => $port->charterers,
                'agents'     => $port->agents->map(fn($agent) => $agent->toArray())->toArray(),
            ];
        })->toArray();
    }

    public function addPort()
    {
        $this->ports[] = [
            'voyage_no' => '',
            'cargo' => '',
            'charterers' => '',
            'agents' => [
                [
                    'port_of_calling' => '',
                    'country' => '',
                    'purpose' => '',
                    'ata_eta_date' => null,
                    'ship_info_date' => null,
                    'gmt' => '',
                    'duration_days' => null,
                    'total_days' => null,
                ]
            ]
        ];
    }

    public function addAgent($portIndex)
    {
        $this->ports[$portIndex]['agents'][] = [
            'port_of_calling' => '',
            'country' => '',
            'purpose' => '',
            'ata_eta_date' => null,
            'ship_info_date' => null,
            'gmt' => '',
            'duration_days' => null,
            'total_days' => null,
        ];
    }

    public function removeAgent($portIndex, $agentIndex)
    {
        unset($this->ports[$portIndex]['agents'][$agentIndex]);
        $this->ports[$portIndex]['agents'] = array_values($this->ports[$portIndex]['agents']);
    }

    public function removePort($index)
    {
        unset($this->ports[$index]);
        $this->ports = array_values($this->ports);
    }

    public function update()
    {
        $this->validate([
            'vessel_id' => 'required|exists:vessels,id',
            'master_info' => 'nullable|string|max:5000',
        ]);

        $voyage = Voyage::findOrFail($this->voyageId);

        $voyage->update([
            'vessel_id' => $this->vessel_id,
            'voyage_no' => $this->voyage_no,
            'call_sign' => $this->call_sign,
            'flag' => $this->flag,
            'port_of_registry' => $this->port_of_registry,
            'official_number' => $this->official_number,
            'imo_number' => $this->imo_number,
            'class_society' => $this->class_society,
            'class_no' => $this->class_no,
            'pi_club' => $this->pi_club,
            'loa' => $this->loa,
            'lbp' => $this->lbp,
            'breadth_extreme' => $this->breadth_extreme,
            'depth_moulded' => $this->depth_moulded,
            'height_maximum' => $this->height_maximum,
            'bridge_front_bow' => $this->bridge_front_bow,
            'bridge_front_stern' => $this->bridge_front_stern,
            'light_ship_displacement' => $this->light_ship_displacement,
            'keel_laid' => $this->keel_laid,
            'launched' => $this->launched,
            'delivered' => $this->delivered,
            'shipyard' => $this->shipyard,
        ]);

        $voyage->remarks()->updateOrCreate([], ['remarks' => $this->remarks]);
        $voyage->master_info()->updateOrCreate([], ['master_info' => $this->master_info]);

        // Sync ports + agents
        $voyage->ports()->delete();
        foreach ($this->ports as $portData) {
            $agents = $portData['agents'];
            unset($portData['agents']);
            $port = $voyage->ports()->create($portData);

            foreach ($agents as $agentData) {
                $port->agents()->create($agentData);
            }
        }

        Notification::create([
            'vessel_id' => $voyage->vessel_id,
            'text'      => "{$voyage->report_type} report has been updated.",
        ]);

        Audit::create([
            'user'       => Auth::user()->name,
            'event'      => 'updated_port_of_call_report',
            'old_values' => [],
            'new_values' => ['report_type' => $voyage->report_type],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Toaster::success('Port Of Call Updated Successfully.');

        return $this->redirectRoute('table-port-of-call-report');
    }

    public function render()
    {
        return view('livewire.unit.edit-port-of-call-report');
    }
}
