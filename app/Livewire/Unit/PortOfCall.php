<?php

namespace App\Livewire\Unit;

use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use App\Models\Voyage;

class PortOfCall extends Component
{
    public $vessel_id;
    public $voyage_no;
    public $ports = [];

    public $master_info;
    public $vesselName = null;

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
                    'ata_eta_date' => '',
                    'ata_eta_time' => '',
                    'ship_info_date' => '',
                    'ship_info_time' => '',
                    'gmt' => '',
                    'duration_days' => '',
                    'total_days' => '',
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
            'ata_eta_date' => '',
            'ata_eta_time' => '',
            'ship_info_date' => '',
            'ship_info_time' => '',
            'gmt' => '',
            'duration_days' => '',
            'total_days' => '',
        ];
    }

    public function clearForm()
    {
        $this->reset([
            'master_info',
            'ports',
            'call_sign',
            'flag',
            'port_of_registry',
            'official_number',
            'imo_number',
            'class_society',
            'class_no',
            'pi_club',
            'loa',
            'lbp',
            'breadth_extreme',
            'depth_moulded',
            'height_maximum',
            'bridge_front_bow',
            'bridge_front_stern',
            'light_ship_displacement',
            'keel_laid',
            'launched',
            'delivered',
            'shipyard',
        ]);

        $this->addPort();
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

    public function save()
    {
        $this->validate([
            'vessel_id' => 'required|exists:vessels,id',
            'master_info' => 'nullable|string|max:5000',

            'call_sign' => 'required|string|max:255',
            'flag' => 'required|string|max:255',
            'port_of_registry' => 'required|string|max:255',
            'official_number' => 'required|string|max:255',
            'imo_number' => 'required|string|max:255',
            'class_society' => 'required|string|max:255',
            'class_no' => 'required|string|max:255',
            'pi_club' => 'required|string|max:255',
            'loa' => 'required|string|max:255',
            'lbp' => 'required|string|max:255',
            'breadth_extreme' => 'required|string|max:255',
            'depth_moulded' => 'required|string|max:255',
            'height_maximum' => 'required|string|max:255',
            'bridge_front_bow' => 'required|string|max:255',
            'bridge_front_stern' => 'required|string|max:255',
            'light_ship_displacement' => 'required|string|max:255',
            'keel_laid' => 'required|date',
            'launched' => 'required|date',
            'delivered' => 'required|date',
            'shipyard' => 'required|string|max:255',
        ]);

        $voyage = Voyage::create([
            'vessel_id' => $this->vessel_id,
            'unit_id' => Auth::id(),
            'report_type' => 'Port Of Call',

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

        Notification::create([
            'text' => "{$voyage->report_type} report has been created.",
        ]);

        foreach ($this->ports as $portData) {
            $port = $voyage->ports()->create($portData);

            foreach ($portData['agents'] as $agentData) {
                $port->agents()->create($agentData);
            }
        }

        Toaster::success('Port Of Call Created Successfully.');
        $voyage->master_info()->create(['master_info' => $this->master_info]);
        $this->clearForm();
    }

    public function render()
    {
        return view('livewire.unit.port-of-call');
    }
}
