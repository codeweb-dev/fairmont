<?php

namespace App\Livewire\Unit;

use App\Models\Audit;
use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use App\Models\Voyage;
use Illuminate\Support\Facades\Session;

class PortOfCall extends Component
{
    public $vessel_id;
    public $voyage_no;
    public $ports = [];
    public $master_info;
    public $remarks;
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

    public array $gmtOffsets = [
        "GMT-12:00", "GMT-11:00", "GMT-10:00", "GMT-09:30", "GMT-09:00",
        "GMT-08:00", "GMT-07:00", "GMT-06:00", "GMT-05:00", "GMT-04:30",
        "GMT-04:00", "GMT-03:30", "GMT-03:00", "GMT-02:30", "GMT-02:00",
        "GMT-01:00", "GMT", "GMT+01:00", "GMT+02:00", "GMT+02:30",
        "GMT+03:00", "GMT+03:30", "GMT+04:00", "GMT+04:30", "GMT+05:00",
        "GMT+05:30", "GMT+06:00", "GMT+06:30", "GMT+07:00", "GMT+08:00",
        "GMT+09:00", "GMT+09:30", "GMT+10:00", "GMT+10:30", "GMT+11:00",
        "GMT+11:30", "GMT+12:00", "GMT+12:45", "GMT+13:00", "GMT+13:45",
        "GMT+14:00",
    ];

    protected $listeners = ['saveDraft', 'autoSave'];

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
        $this->saveDraftToSession();
        // Toaster::success('Draft saved successfully!');
    }

    // public function saveDraft()
    // {
    //     $this->saveDraftToSession();
    //     Toaster::success('Draft saved successfully!');
    //     $this->dispatch('draftSaved');
    // }

    private function saveDraftToSession()
    {
        Session::put('port_of_call_draft_' . Auth::id(), $this->only(array_keys(get_object_vars($this))));
    }

    public function loadDraft()
    {
        $draft = Session::get('port_of_call_draft_' . Auth::id());
        if ($draft) {
            foreach ($draft as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }
    }

    public function clearDraft()
    {
        $draftKey = 'port_of_call_draft_' . Auth::id();
        Session::forget($draftKey);
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
    }

    public function clearForm()
    {
        $this->clearDraft();
        $this->reset([
            'remarks', 'master_info', 'ports', 'call_sign', 'flag',
            'port_of_registry', 'official_number', 'imo_number', 'class_society',
            'class_no', 'pi_club', 'loa', 'lbp', 'breadth_extreme',
            'depth_moulded', 'height_maximum', 'bridge_front_bow',
            'bridge_front_stern', 'light_ship_displacement', 'keel_laid',
            'launched', 'delivered', 'shipyard',
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
                $agentData['duration_days'] = $agentData['duration_days'] !== '' ? (int) $agentData['duration_days'] : null;
                $agentData['total_days'] = $agentData['total_days'] !== '' ? (int) $agentData['total_days'] : null;
                $port->agents()->create($agentData);
            }
        }

        Toaster::success('Port Of Call Created Successfully.');
        $voyage->master_info()->create(['master_info' => $this->master_info]);
        $voyage->remarks()->create(['remarks' => $this->remarks]);

        Audit::create([
            'auditable_id'   => $voyage->id,
            'auditable_type' => Voyage::class,
            'user_id'        => Auth::id(),
            'event'          => 'created_port_of_call_report',
            'old_values'     => [],
            'new_values'     => [
                'report_type' => $voyage->report_type,
            ],
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
        ]);

        $this->clearDraft();
        $this->clearForm();
        $this->redirect('/table-port-of-call-report');
    }

    public function render()
    {
        return view('livewire.unit.port-of-call');
    }
}
