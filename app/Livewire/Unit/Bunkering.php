<?php

namespace App\Livewire\Unit;

use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use App\Models\Voyage;

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

    public array $gmtOffsets = [];
    public array $_supplier = [];

    public $vesselName = null;

    public function mount()
    {
        $user = Auth::user();
        $vessel = $user->vessels()->first();

        if ($vessel) {
            $this->vessel_id = $vessel->id;
            $this->vesselName = $vessel->name;
        } else {
            abort(403, 'You are not assigned to a vessel.');
        }

        $this->gmtOffsets = [
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

        $this->_supplier = [
            "AVS Global Risk Management Ltd. Fondsmaeglerselskab",
            "‘Adani Bunkering Pvt. Lid",
            "Amol International Limited",
            "tutus Pont Marne id",
            "Ast Bunker LLC",
            "BMT Bunker und Mineraloltransport GmbH",
            "Bomin Atlantic LLC",
            "Bomin Bunker Oil Corp.",
            "Bp Marine Ltd",
            "BP Singapore Pte. Ltd",
            "Bunker Hedge Allocation",
            "C.I Quality Bunkers Supply S.A.S",
            "Cepsa Marine Fuels. S.A.",
            "Chevron Marine Products LLC",
            "Chimbusco Pan Nation Petro-Chemical Co. Ltd",
            "Chimbusco International Petroleum (Singapore) Pte. Ltd",
            "Clipper Oil Inc",
            "Cockett Marine Oil (Asia)",
            "Compania Espanola de Petroleos S.A.",
            "Costank (S) Pte Ltd",
            "Equatorial Marine Fuel Management Services Pte Ltd",
            "Fal Energy Co., Ltd.",
            "Fratelli Consulich Bunkers(HK)",
            "General Petroleum LLC dba PTL Marine",
            "Global Companies L.L.C.",
            "Golden Island Diesel Oil Trading Pte Ltd",
            "Goodfuels B.V.",
            "Hanwa Singapore (Pte) Ltd",
            "Harbor Plaza Consolidated",
            "Ian Taylor Y Cia. S.A.",
            "Island Oil Limited",
            "J Aron & Co GS (Singapore)",
            "The Jankovich Company",
            "Japan Energy",
            "John W.Stone Oil Distributor LLC",
            "Kanematsu Corporation",
            "KPI Oceanconnect Global Accounts Pte. Ltd",
            "KPI Oceanconnect Global Accounts Ltd",
            "Manildra Park Pty Ltd",
            "Marathon Petroleum Company LP",
            "Marine Petrobulk Ltd Partnership",
            "Marubeni Corporation",
            "Marubeni Petroleum Co. Ltd.",
            "Minerva Bunkering (USA) LLC",
            "Minerva Bunkering Pte Ltd",
            "Mitsui & Co Energy Risk Mgt",
            "Monjasa Pte. Ltd.",
            "Morgan Stanley",
            "Nayada Agency Co., Ltd",
            "O Rourke Marine Services",
            "Panthera Energy Trading USA Inc",
            "Peninsula Petroleum Ltd.",
            "Peninsula Petroleum Far East Pte. Ltd.",
            "Prio Supply S.A.",
            "Propeller Fuels Ltd",
            "Raizen S.A.",
            "SARAS SpA",
            "Sea Swift Pty Ltd.",
            "Sinanen Co., Ltd.",
            "Skandinaviska Enskilda Banken AB (publ.)",
            "Skygroup Logistics Limited",
            "TFG Marine Pte Ltd",
            "Tropic Oil Company",
            "Total Bunkering SA",
            "Toyota Tsusho Marine Fuels Corporation",
            "Trefoil Trading B.V.",
            "Varo Energy Germany GmbH",
            "Veritas Petroleum Services B.V.(Head office)",
            "VOOIL LLC",
            "Voy Exp/Rev Allocation-Bunker",
            "World Fuel Services",
            "Yingkou Ocean Favor Shipping Agency Co. Ltd."
        ];
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
            'port_delivery' => 'required|string',
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

            // Remarks and Master's Info
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
        $this->clearForm();
    }

    public function export()
    {
        Toaster::info('Export feature not implemented yet.');
    }

    public function clearForm()
    {
        $this->reset([
            'voyage_no',
            'bunkering_port',
            'supplier',
            'port_etd',
            'port_gmt_offset',
            'bunker_completed',
            'bunker_gmt_offset',
            'remarks',
            'master_info',

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
        ]);
    }

    public function render()
    {
        return view('livewire.unit.bunkering');
    }
}
