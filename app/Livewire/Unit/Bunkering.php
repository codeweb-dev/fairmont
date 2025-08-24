<?php

namespace App\Livewire\Unit;

use App\Models\Audit;
use App\Models\Draft;
use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use App\Models\Voyage;
use Illuminate\Support\Facades\Session;

class Bunkering extends Component
{
    // Bunkering
    public $vessel_id;
    public $voyage_no;
    public $bunkering_port;
    public $supplier;
    public $port_etd;
    public $port_gmt_offset;
    public $bunker_completed;
    public $bunker_gmt_offset;

    // BunkerType fields
    public $hsfo_quantity;
    public $hsfo_viscosity;
    public $biofuel_quantity;
    public $biofuel_viscosity;
    public $vlsfo_quantity;
    public $vlsfo_viscosity;
    public $lsmgo_quantity;
    public $lsmgo_viscosity;

    // AssociatedInformation fields
    public $port_delivery;
    public $eosp;
    public $eosp_gmt;
    public $barge;
    public $barge_gmt;
    public $cosp;
    public $cosp_gmt;
    public $anchor;
    public $anchor_gmt;
    public $pumping;
    public $pumping_gmt;

    // Remarks & Master Info
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

    protected $listeners = ['saveDraft'];

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

        $this->loadDraft();
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
                'type' => 'bunkering',
            ],
            [
                'data' => json_encode($this->only([
                    'voyage_no',
                    'bunkering_port',
                    'supplier',
                    'port_etd',
                    'port_gmt_offset',
                    'bunker_completed',
                    'bunker_gmt_offset',

                    'hsfo_quantity',
                    'hsfo_viscosity',
                    'biofuel_quantity',
                    'biofuel_viscosity',
                    'vlsfo_quantity',
                    'vlsfo_viscosity',
                    'lsmgo_quantity',
                    'lsmgo_viscosity',

                    'port_delivery',
                    'eosp',
                    'eosp_gmt',
                    'barge',
                    'barge_gmt',
                    'cosp',
                    'cosp_gmt',
                    'anchor',
                    'anchor_gmt',
                    'pumping',
                    'pumping_gmt',

                    'remarks',
                    'master_info',
                ])),
            ]
        );

        $this->dispatch('draftSaved');
    }

    public function loadDraft()
    {
        $draft = Draft::where('user_id', Auth::id())
            ->where('type', 'bunkering')
            ->first();

        if ($draft) {
            $data = json_decode($draft->data, true);

            $this->voyage_no = $data['voyage_no'] ?? null;
            $this->bunkering_port = $data['bunkering_port'] ?? null;
            $this->supplier = $data['supplier'] ?? null;
            $this->port_etd = $data['port_etd'] ?? null;
            $this->port_gmt_offset = $data['port_gmt_offset'] ?? null;
            $this->bunker_completed = $data['bunker_completed'] ?? null;
            $this->bunker_gmt_offset = $data['bunker_gmt_offset'] ?? null;

            $this->hsfo_quantity = $data['hsfo_quantity'] ?? null;
            $this->hsfo_viscosity = $data['hsfo_viscosity'] ?? null;
            $this->biofuel_quantity = $data['biofuel_quantity'] ?? null;
            $this->biofuel_viscosity = $data['biofuel_viscosity'] ?? null;
            $this->vlsfo_quantity = $data['vlsfo_quantity'] ?? null;
            $this->vlsfo_viscosity = $data['vlsfo_viscosity'] ?? null;
            $this->lsmgo_quantity = $data['lsmgo_quantity'] ?? null;
            $this->lsmgo_viscosity = $data['lsmgo_viscosity'] ?? null;

            $this->port_delivery = $data['port_delivery'] ?? null;
            $this->eosp = $data['eosp'] ?? null;
            $this->eosp_gmt = $data['eosp_gmt'] ?? null;
            $this->barge = $data['barge'] ?? null;
            $this->barge_gmt = $data['barge_gmt'] ?? null;
            $this->cosp = $data['cosp'] ?? null;
            $this->cosp_gmt = $data['cosp_gmt'] ?? null;
            $this->anchor = $data['anchor'] ?? null;
            $this->anchor_gmt = $data['anchor_gmt'] ?? null;
            $this->pumping = $data['pumping'] ?? null;
            $this->pumping_gmt = $data['pumping_gmt'] ?? null;

            $this->remarks = $data['remarks'] ?? null;
            $this->master_info = $data['master_info'] ?? null;
        }
    }

    public function clearDraft()
    {
        Draft::where('user_id', Auth::id())
            ->where('type', 'bunkering')
            ->delete();
    }

    public function save()
    {
        $this->validate([
            // Voyage + Bunkering Core Fields
            'vessel_id' => 'required|exists:vessels,id',
            'voyage_no' => 'required|string|max:50',
            'bunkering_port' => 'required|string|max:255',
            'supplier' => 'required|string|max:255',
            'port_etd' => 'required|date',
            'port_gmt_offset' => 'required|string',
            'bunker_completed' => 'required|date',
            'bunker_gmt_offset' => 'required|string',

            // Bunker Type Fields
            'hsfo_quantity' => 'nullable|numeric|min:0',
            'hsfo_viscosity' => 'nullable|string',
            'biofuel_quantity' => 'nullable|numeric|min:0',
            'biofuel_viscosity' => 'nullable|string',
            'vlsfo_quantity' => 'nullable|numeric|min:0',
            'vlsfo_viscosity' => 'nullable|string',
            'lsmgo_quantity' => 'nullable|numeric|min:0',
            'lsmgo_viscosity' => 'nullable|string',

            // Associated Info Fields
            'port_delivery' => 'nullable|string',
            'eosp' => 'nullable|date',
            'eosp_gmt' => 'nullable|string',
            'barge' => 'nullable|date',
            'barge_gmt' => 'nullable|string',
            'cosp' => 'nullable|date',
            'cosp_gmt' => 'nullable|string',
            'anchor' => 'nullable|date',
            'anchor_gmt' => 'nullable|string',
            'pumping' => 'nullable|date',
            'pumping_gmt' => 'nullable|string',

            // Remarks and Master Information
            'remarks' => 'nullable|string|max:5000',
            'master_info' => 'nullable|string|max:5000',
        ]);

        $voyage = Voyage::create([
            'vessel_id' => $this->vessel_id,
            'unit_id' => Auth::id(),
            'report_type' => 'Bunkering',
            'voyage_no' => $this->voyage_no,
            'bunkering_port' => $this->bunkering_port,
            'supplier' => $this->supplier,
            'port_etd' => $this->port_etd,
            'port_gmt_offset' => $this->port_gmt_offset,
            'bunker_completed' => $this->bunker_completed,
            'bunker_gmt_offset' => $this->bunker_gmt_offset,
        ]);

        Notification::create([
            'text' => "{$voyage->report_type} report has been created.",
        ]);

        // Remarks and Master Info
        $voyage->remarks()->create(['remarks' => $this->remarks]);
        $voyage->master_info()->create(['master_info' => $this->master_info]);

        Audit::create([
            'auditable_id'   => $voyage->id,
            'auditable_type' => Voyage::class,
            'user_id'        => Auth::id(),
            'event'          => 'created_bunkering_report',
            'old_values'     => [],
            'new_values'     => [
                'report_type' => $voyage->report_type,
            ],
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
        ]);

        // Bunker Type
        $voyage->bunker()->create([
            'hsfo_quantity' => $this->hsfo_quantity,
            'hsfo_viscosity' => $this->hsfo_viscosity,
            'biofuel_quantity' => $this->biofuel_quantity,
            'biofuel_viscosity' => $this->biofuel_viscosity,
            'vlsfo_quantity' => $this->vlsfo_quantity,
            'vlsfo_viscosity' => $this->vlsfo_viscosity,
            'lsmgo_quantity' => $this->lsmgo_quantity,
            'lsmgo_viscosity' => $this->lsmgo_viscosity,
        ]);

        // Associated Info
        $voyage->assiociated_information()->create([
            'port_delivery' => $this->port_delivery,
            'eosp' => $this->eosp,
            'eosp_gmt' => $this->eosp_gmt,
            'barge' => $this->barge,
            'barge_gmt' => $this->barge_gmt,
            'cosp' => $this->cosp,
            'cosp_gmt' => $this->cosp_gmt,
            'anchor' => $this->anchor,
            'anchor_gmt' => $this->anchor_gmt,
            'pumping' => $this->pumping,
            'pumping_gmt' => $this->pumping_gmt,
        ]);

        Toaster::success('Bunkering Report Created Successfully.');
        $this->clearDraft();
        $this->clearForm();

        $this->redirect('/table-bunkering-report');
    }

    public function clearForm()
    {
        $this->clearDraft();

        $this->reset([
            'voyage_no',
            'bunkering_port',
            'supplier',
            'port_etd',
            'port_gmt_offset',
            'bunker_completed',
            'bunker_gmt_offset',

            'hsfo_quantity',
            'hsfo_viscosity',
            'biofuel_quantity',
            'biofuel_viscosity',
            'vlsfo_quantity',
            'vlsfo_viscosity',
            'lsmgo_quantity',
            'lsmgo_viscosity',

            'port_delivery',
            'eosp',
            'eosp_gmt',
            'barge',
            'barge_gmt',
            'cosp',
            'cosp_gmt',
            'anchor',
            'anchor_gmt',
            'pumping',
            'pumping_gmt',

            'remarks',
            'master_info',
        ]);
    }

    public function render()
    {
        return view('livewire.unit.bunkering');
    }
}
