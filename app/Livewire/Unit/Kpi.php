<?php

namespace App\Livewire\Unit;

use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use App\Models\Voyage;

class Kpi extends Component
{
    public $vessel_id;
    // Voyage Information
    public $all_fast_datetime; // as reporting period
    public $port; // as fleet
    public $gmt_offset; // as vessel type

    // Voyage
    public $call_sign; // as total_sailing days
    public $flag; // as eco speed sailing days
    public $port_of_registry; // as full speed sailing days

    // Crew
    public $official_number; // as no. of Fatalities
    public $imo_number; // as LTI
    public $class_society; // as no. of Recordable Injuries

    // MACN
    public $class_no; // as No. of Corruption/Bribery/Entertainment for Port Officials

    // Inspection
    public $pi_club; // as Number of PSC Inspections
    public $loa; // as PSC No. of Deficiencies
    public $lbp; // as PSC Detentions (if any)
    public $breadth_extreme; // as Number of Flag State Inspections
    public $depth_moulded; // as Flag No. of Deficiencies
    public $height_maximum; // as Third Party Inspections (Charterers, Owners, RISQ, Others)
    public $bridge_front_bow; // as Third Party No. of Deficiencie

    public $master_info;
    public $remarks;
    public $vesselName = null;

    public $plastics_landed_ashore, $plastics_incinerated;
    public $food_disposed_sea, $food_landed_ashore;
    public $domestic_landed_ashore, $domestic_incinerated;
    public $cooking_oil_landed_ashore, $cooking_oil_incinerated;
    public $incinerator_ash_landed_ashore, $incinerator_ash_incinerated;
    public $operational_landed_ashore, $operational_incinerated;
    public $ewaste_landed_ashore, $cargo_residues_landed_ashore;
    public $total_garbage_disposed_sea, $total_garbage_landed_ashore;
    public $sludge_landed_ashore, $sludge_incinerated, $sludge_generated, $fuel_consumed;
    public $sludge_bunker_ratio, $sludge_remarks;
    public $bilge_discharged_ows, $bilge_landed_ashore, $bilge_generated;
    public $paper_consumption, $printer_cartridges, $consumption_remarks;
    public $fresh_water_generated, $fresh_water_consumed;
    public $ballast_exchanges, $ballast_operations, $deballast_operations;
    public $ballast_intake, $ballast_out, $ballast_exchange_amount;
    public $propeller_cleanings, $hull_cleanings;

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
            'report_type' => 'KPI',
            'port' => $this->port,
            'all_fast_datetime' => $this->all_fast_datetime,

            // Voyage
            'call_sign' => $this->call_sign,
            'flag' => $this->flag,
            'port_of_registry' => $this->port_of_registry,

            // Crew
            'official_number' => $this->official_number,
            'imo_number' => $this->imo_number,
            'class_society' => $this->class_society,

            // MACN
            'class_no' => $this->class_no,

            // Inspection
            'pi_club' => $this->pi_club,
            'loa' => $this->loa,
            'lbp' => $this->lbp,
            'breadth_extreme' => $this->breadth_extreme,
            'depth_moulded' => $this->depth_moulded,
            'height_maximum' => $this->height_maximum,
            'bridge_front_bow' => $this->bridge_front_bow,
        ]);

        $voyage->waste()->create([
            'plastics_landed_ashore' => $this->plastics_landed_ashore,
            'plastics_incinerated' => $this->plastics_incinerated,
            'food_disposed_sea' => $this->food_disposed_sea,
            'food_landed_ashore' => $this->food_landed_ashore,
            'domestic_landed_ashore' => $this->domestic_landed_ashore,
            'domestic_incinerated' => $this->domestic_incinerated,
            'cooking_oil_landed_ashore' => $this->cooking_oil_landed_ashore,
            'cooking_oil_incinerated' => $this->cooking_oil_incinerated,
            'incinerator_ash_landed_ashore' => $this->incinerator_ash_landed_ashore,
            'incinerator_ash_incinerated' => $this->incinerator_ash_incinerated,
            'operational_landed_ashore' => $this->operational_landed_ashore,
            'operational_incinerated' => $this->operational_incinerated,
            'ewaste_landed_ashore' => $this->ewaste_landed_ashore,
            'cargo_residues_landed_ashore' => $this->cargo_residues_landed_ashore,
            'total_garbage_disposed_sea' => $this->total_garbage_disposed_sea,
            'total_garbage_landed_ashore' => $this->total_garbage_landed_ashore,
            'sludge_landed_ashore' => $this->sludge_landed_ashore,
            'sludge_incinerated' => $this->sludge_incinerated,
            'sludge_generated' => $this->sludge_generated,
            'fuel_consumed' => $this->fuel_consumed,
            'sludge_bunker_ratio' => $this->sludge_bunker_ratio,
            'sludge_remarks' => $this->sludge_remarks,
            'bilge_discharged_ows' => $this->bilge_discharged_ows,
            'bilge_landed_ashore' => $this->bilge_landed_ashore,
            'bilge_generated' => $this->bilge_generated,
            'paper_consumption' => $this->paper_consumption,
            'printer_cartridges' => $this->printer_cartridges,
            'consumption_remarks' => $this->consumption_remarks,
            'fresh_water_generated' => $this->fresh_water_generated,
            'fresh_water_consumed' => $this->fresh_water_consumed,
            'ballast_exchanges' => $this->ballast_exchanges,
            'ballast_operations' => $this->ballast_operations,
            'deballast_operations' => $this->deballast_operations,
            'ballast_intake' => $this->ballast_intake,
            'ballast_out' => $this->ballast_out,
            'ballast_exchange_amount' => $this->ballast_exchange_amount,
            'propeller_cleanings' => $this->propeller_cleanings,
            'hull_cleanings' => $this->hull_cleanings,
        ]);

        $voyage->master_info()->create(['master_info' => $this->master_info]);
        $voyage->remarks()->create(['remarks' => $this->remarks]);

        Notification::create([
            'text' => "{$voyage->report_type} report has been created.",
        ]);

        Toaster::success('KPI Created Successfully.');
        $this->clearForm();
    }

    public function clearForm()
    {
        // Voyage Information
        $this->all_fast_datetime = $this->port = $this->gmt_offset = $this->master_info = $this->remarks = null;

        // Waste Management
        $this->plastics_landed_ashore = $this->plastics_incinerated = null;
        $this->food_disposed_sea = $this->food_landed_ashore = null;
        $this->domestic_landed_ashore = $this->domestic_incinerated = null;
        $this->cooking_oil_landed_ashore = $this->cooking_oil_incinerated = null;
        $this->incinerator_ash_landed_ashore = $this->incinerator_ash_incinerated = null;
        $this->operational_landed_ashore = $this->operational_incinerated = null;
        $this->ewaste_landed_ashore = $this->cargo_residues_landed_ashore = null;
        $this->total_garbage_disposed_sea = $this->total_garbage_landed_ashore = null;
        $this->sludge_landed_ashore = $this->sludge_incinerated = $this->sludge_generated = $this->fuel_consumed = null;
        $this->sludge_bunker_ratio = $this->sludge_remarks = null;
        $this->bilge_discharged_ows = $this->bilge_landed_ashore = $this->bilge_generated = null;
        $this->paper_consumption = $this->printer_cartridges = $this->consumption_remarks = null;
        $this->fresh_water_generated = $this->fresh_water_consumed = null;
        $this->ballast_exchanges = $this->ballast_operations = $this->deballast_operations = null;
        $this->ballast_intake = $this->ballast_out = $this->ballast_exchange_amount = null;
        $this->propeller_cleanings = $this->hull_cleanings = null;

        // Sailing Days (renamed inputs)
        $this->call_sign = $this->flag = $this->port_of_registry = null;

        // Crew Safety Metrics
        $this->official_number = $this->imo_number = $this->class_society = null;

        // MACN Reports
        $this->class_no = null;

        // Inspections
        $this->pi_club = $this->loa = $this->lbp = null;
        $this->breadth_extreme = $this->depth_moulded = $this->height_maximum = $this->bridge_front_bow = null;
    }

    public function render()
    {
        return view('livewire.unit.kpi');
    }
}
