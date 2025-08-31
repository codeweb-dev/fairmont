<?php

namespace App\Livewire\Unit;

use App\Models\Audit;
use App\Models\Draft;
use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use App\Models\Voyage;
use App\Models\Vessel as ModelsVessel;

class PortOfCall extends Component
{
    public $vessel_id;
    public $voyage_no;
    public $ports = [];
    public $master_info;
    public $remarks;
    public $vesselName;
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

        if (empty($this->ports)) {
            $this->addPort();
        }
    }

    public function autoSave()
    {
        $this->saveDraftToDatabase();
    }

    private function saveDraftToDatabase()
    {
        $data = [
            'vessel_id'            => $this->vessel_id,
            'voyage_no'            => $this->voyage_no,
            'remarks'              => $this->remarks,
            'master_info'          => $this->master_info,
            'ports'                => $this->ports,
            'call_sign'            => $this->call_sign,
            'flag'                 => $this->flag,
            'port_of_registry'     => $this->port_of_registry,
            'official_number'      => $this->official_number,
            'imo_number'           => $this->imo_number,
            'class_society'        => $this->class_society,
            'class_no'             => $this->class_no,
            'pi_club'              => $this->pi_club,
            'loa'                  => $this->loa,
            'lbp'                  => $this->lbp,
            'breadth_extreme'      => $this->breadth_extreme,
            'depth_moulded'        => $this->depth_moulded,
            'height_maximum'       => $this->height_maximum,
            'bridge_front_bow'     => $this->bridge_front_bow,
            'bridge_front_stern'   => $this->bridge_front_stern,
            'light_ship_displacement' => $this->light_ship_displacement,
            'keel_laid'            => $this->keel_laid,
            'launched'             => $this->launched,
            'delivered'            => $this->delivered,
            'shipyard'             => $this->shipyard,
        ];

        Draft::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'type'    => 'port_of_call',
            ],
            [
                'data' => json_encode($data),
            ]
        );

        $this->dispatch('draftSaved');
    }

    public function loadDraft()
    {
        $draft = Draft::where('user_id', Auth::id())
            ->where('type', 'port_of_call')
            ->first();

        if ($draft) {
            $data = json_decode($draft->data, true);

            $this->voyage_no            = $data['voyage_no'] ?? null;
            $this->remarks              = $data['remarks'] ?? null;
            $this->master_info          = $data['master_info'] ?? null;
            $this->ports                = $data['ports'] ?? $this->ports;
            $this->call_sign            = $data['call_sign'] ?? null;
            $this->flag                 = $data['flag'] ?? null;
            $this->port_of_registry     = $data['port_of_registry'] ?? null;
            $this->official_number      = $data['official_number'] ?? null;
            $this->imo_number           = $data['imo_number'] ?? null;
            $this->class_society        = $data['class_society'] ?? null;
            $this->class_no             = $data['class_no'] ?? null;
            $this->pi_club              = $data['pi_club'] ?? null;
            $this->loa                  = $data['loa'] ?? null;
            $this->lbp                  = $data['lbp'] ?? null;
            $this->breadth_extreme      = $data['breadth_extreme'] ?? null;
            $this->depth_moulded        = $data['depth_moulded'] ?? null;
            $this->height_maximum       = $data['height_maximum'] ?? null;
            $this->bridge_front_bow     = $data['bridge_front_bow'] ?? null;
            $this->bridge_front_stern   = $data['bridge_front_stern'] ?? null;
            $this->light_ship_displacement = $data['light_ship_displacement'] ?? null;
            $this->keel_laid            = $data['keel_laid'] ?? null;
            $this->launched             = $data['launched'] ?? null;
            $this->delivered            = $data['delivered'] ?? null;
            $this->shipyard             = $data['shipyard'] ?? null;
        }
    }

    public function clearDraft()
    {
        Draft::where('user_id', Auth::id())
            ->where('type', 'port_of_call')
            ->delete();
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
                    'ata_eta_time' => null,
                    'ship_info_date' => null,
                    'ship_info_time' => null,
                    'gmt' => '',
                    'duration_days' => null,
                    'total_days' => null,
                ]
            ]
        ];
        $this->saveDraftToDatabase();
    }

    public function addAgent($portIndex)
    {
        $this->ports[$portIndex]['agents'][] = [
            'port_of_calling' => '',
            'country' => '',
            'purpose' => '',
            'ata_eta_date' => null,
            'ata_eta_time' => null,
            'ship_info_date' => null,
            'ship_info_time' => null,
            'gmt' => '',
            'duration_days' => null,
            'total_days' => null,
        ];
        $this->saveDraftToDatabase();
    }

    public function clearForm()
    {
        $this->clearDraft();
        $this->reset([
            'remarks',
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
        $this->saveDraftToDatabase();
    }

    public function removePort($index)
    {
        unset($this->ports[$index]);
        $this->ports = array_values($this->ports);
        $this->saveDraftToDatabase();
    }

    public function save()
    {
        $this->validate([
            'vessel_id' => 'required|exists:vessels,id',
            'master_info' => 'nullable|string|max:5000',
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
            'vessel_id' => $voyage->vessel_id,
            'text'      => "{$voyage->report_type} report has been created.",
        ]);

        foreach ($this->ports as $portData) {
            $port = $voyage->ports()->create($portData);
            foreach ($portData['agents'] as $agentData) {
                $agentData['duration_days'] = $agentData['duration_days'] !== '' ? (int) $agentData['duration_days'] : null;
                $agentData['total_days'] = $agentData['total_days'] !== '' ? (int) $agentData['total_days'] : null;
                $port->agents()->create($agentData);
            }
        }

        Toaster::success('Port Of Call Created Successfully.');
        $voyage->master_info()->create(['master_info' => $this->master_info]);
        $voyage->remarks()->create(['remarks' => $this->remarks]);

        Audit::create([
            'user'          => Auth::user()->name,
            'event'          => 'created_port_of_call_report',
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
        $this->redirect('/table-port-of-call-report');
    }

    public function render()
    {
        return view('livewire.unit.port-of-call');
    }
}
