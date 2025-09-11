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
    public $food_disposed_sea, $food_landed_ashore, $food_total_incinerated;
    public $domestic_landed_ashore, $domestic_incinerated;
    public $cooking_oil_landed_ashore, $cooking_oil_incinerated;
    public $incinerator_ash_landed_ashore, $incinerator_ash_incinerated;
    public $operational_landed_ashore, $operational_incinerated;
    public $ewaste_landed_ashore, $ewaste_landed_total_incinerated, $cargo_residues_landed_ashore, $cargo_residues_disposed_at_sea;
    public $total_garbage_disposed_sea, $total_garbage_landed_ashore;
    public $sludge_landed_ashore, $sludge_incinerated, $sludge_generated, $fuel_consumed;
    public $sludge_bunker_ratio, $sludge_remarks;
    public $bilge_discharged_ows, $bilge_landed_ashore, $bilge_generated;
    public $paper_consumption, $printer_cartridges, $consumption_remarks;
    public $fresh_water_generated, $fresh_water_consumed;
    public $ballast_exchanges, $ballast_operations, $deballast_operations;
    public $ballast_intake, $ballast_out, $ballast_exchange_amount;
    public $propeller_cleanings, $hull_cleanings;
    protected $listeners = ['saveDraft'];

    public function autoSave()
    {
        $this->saveDraftToDatabase();
    }

    private function saveDraftToDatabase()
    {
        Draft::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'type'    => 'kpi',
            ],
            [
                'data' => json_encode($this->only([
                    'all_fast_datetime',
                    'port',
                    'gmt_offset',

                    // Voyage
                    'call_sign',
                    'flag',
                    'port_of_registry',

                    // Crew
                    'official_number',
                    'imo_number',
                    'class_society',

                    // MACN
                    'class_no',

                    // Inspection
                    'pi_club',
                    'loa',
                    'lbp',
                    'breadth_extreme',
                    'depth_moulded',
                    'height_maximum',
                    'bridge_front_bow',

                    // Waste
                    'plastics_landed_ashore',
                    'plastics_incinerated',
                    'food_disposed_sea',
                    'food_landed_ashore',
                    'food_total_incinerated',
                    'domestic_landed_ashore',
                    'domestic_incinerated',
                    'cooking_oil_landed_ashore',
                    'cooking_oil_incinerated',
                    'incinerator_ash_landed_ashore',
                    'incinerator_ash_incinerated',
                    'operational_landed_ashore',
                    'operational_incinerated',
                    'ewaste_landed_ashore',
                    'ewaste_landed_total_incinerated',
                    'cargo_residues_landed_ashore',
                    'cargo_residues_disposed_at_sea',
                    'total_garbage_disposed_sea',
                    'total_garbage_landed_ashore',
                    'sludge_landed_ashore',
                    'sludge_incinerated',
                    'sludge_generated',
                    'fuel_consumed',
                    'sludge_bunker_ratio',
                    'sludge_remarks',
                    'bilge_discharged_ows',
                    'bilge_landed_ashore',
                    'bilge_generated',
                    'paper_consumption',
                    'printer_cartridges',
                    'consumption_remarks',
                    'fresh_water_generated',
                    'fresh_water_consumed',
                    'ballast_exchanges',
                    'ballast_operations',
                    'deballast_operations',
                    'ballast_intake',
                    'ballast_out',
                    'ballast_exchange_amount',
                    'propeller_cleanings',
                    'hull_cleanings',

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
            ->where('type', 'kpi')
            ->first();

        if ($draft) {
            $data = json_decode($draft->data, true);

            $this->all_fast_datetime = $data['all_fast_datetime'] ?? null;
            $this->port = $data['port'] ?? null;
            $this->gmt_offset = $data['gmt_offset'] ?? null;

            // Voyage
            $this->call_sign = $data['call_sign'] ?? null;
            $this->flag = $data['flag'] ?? null;
            $this->port_of_registry = $data['port_of_registry'] ?? null;

            // Crew
            $this->official_number = $data['official_number'] ?? null;
            $this->imo_number = $data['imo_number'] ?? null;
            $this->class_society = $data['class_society'] ?? null;

            // MACN
            $this->class_no = $data['class_no'] ?? null;

            // Inspection
            $this->pi_club = $data['pi_club'] ?? null;
            $this->loa = $data['loa'] ?? null;
            $this->lbp = $data['lbp'] ?? null;
            $this->breadth_extreme = $data['breadth_extreme'] ?? null;
            $this->depth_moulded = $data['depth_moulded'] ?? null;
            $this->height_maximum = $data['height_maximum'] ?? null;
            $this->bridge_front_bow = $data['bridge_front_bow'] ?? null;

            // Waste
            $this->plastics_landed_ashore = $data['plastics_landed_ashore'] ?? null;
            $this->plastics_incinerated = $data['plastics_incinerated'] ?? null;
            $this->food_disposed_sea = $data['food_disposed_sea'] ?? null;
            $this->food_landed_ashore = $data['food_landed_ashore'] ?? null;
            $this->food_total_incinerated = $data['food_total_incinerated'] ?? null;
            $this->domestic_landed_ashore = $data['domestic_landed_ashore'] ?? null;
            $this->domestic_incinerated = $data['domestic_incinerated'] ?? null;
            $this->cooking_oil_landed_ashore = $data['cooking_oil_landed_ashore'] ?? null;
            $this->cooking_oil_incinerated = $data['cooking_oil_incinerated'] ?? null;
            $this->incinerator_ash_landed_ashore = $data['incinerator_ash_landed_ashore'] ?? null;
            $this->incinerator_ash_incinerated = $data['incinerator_ash_incinerated'] ?? null;
            $this->operational_landed_ashore = $data['operational_landed_ashore'] ?? null;
            $this->operational_incinerated = $data['operational_incinerated'] ?? null;
            $this->ewaste_landed_ashore = $data['ewaste_landed_ashore'] ?? null;
            $this->ewaste_landed_total_incinerated = $data['ewaste_landed_total_incinerated'] ?? null;
            $this->cargo_residues_landed_ashore = $data['cargo_residues_landed_ashore'] ?? null;
            $this->cargo_residues_disposed_at_sea = $data['cargo_residues_disposed_at_sea'] ?? null;
            $this->total_garbage_disposed_sea = $data['total_garbage_disposed_sea'] ?? null;
            $this->total_garbage_landed_ashore = $data['total_garbage_landed_ashore'] ?? null;
            $this->sludge_landed_ashore = $data['sludge_landed_ashore'] ?? null;
            $this->sludge_incinerated = $data['sludge_incinerated'] ?? null;
            $this->sludge_generated = $data['sludge_generated'] ?? null;
            $this->fuel_consumed = $data['fuel_consumed'] ?? null;
            $this->sludge_bunker_ratio = $data['sludge_bunker_ratio'] ?? null;
            $this->sludge_remarks = $data['sludge_remarks'] ?? null;
            $this->bilge_discharged_ows = $data['bilge_discharged_ows'] ?? null;
            $this->bilge_landed_ashore = $data['bilge_landed_ashore'] ?? null;
            $this->bilge_generated = $data['bilge_generated'] ?? null;
            $this->paper_consumption = $data['paper_consumption'] ?? null;
            $this->printer_cartridges = $data['printer_cartridges'] ?? null;
            $this->consumption_remarks = $data['consumption_remarks'] ?? null;
            $this->fresh_water_generated = $data['fresh_water_generated'] ?? null;
            $this->fresh_water_consumed = $data['fresh_water_consumed'] ?? null;
            $this->ballast_exchanges = $data['ballast_exchanges'] ?? null;
            $this->ballast_operations = $data['ballast_operations'] ?? null;
            $this->deballast_operations = $data['deballast_operations'] ?? null;
            $this->ballast_intake = $data['ballast_intake'] ?? null;
            $this->ballast_out = $data['ballast_out'] ?? null;
            $this->ballast_exchange_amount = $data['ballast_exchange_amount'] ?? null;
            $this->propeller_cleanings = $data['propeller_cleanings'] ?? null;
            $this->hull_cleanings = $data['hull_cleanings'] ?? null;

            $this->remarks = $data['remarks'] ?? null;
            $this->master_info = $data['master_info'] ?? null;
        }
    }

    public function clearDraft()
    {
        Draft::where('user_id', Auth::id())
            ->where('type', 'kpi')
            ->delete();
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
    }

    public function save()
    {
        $this->validate([
            'vessel_id' => 'required|exists:vessels,id',
            'master_info' => 'nullable|string|max:5000',
        ]);

        $vessel = ModelsVessel::findOrFail($this->vessel_id);

        if (!$vessel->is_active) {
            Toaster::error('This vessel has been deactivated. It will no longer be available for new reports.');
            return;
        }

        $voyage = Voyage::create([
            'vessel_id' => $this->vessel_id,
            'unit_id' => Auth::id(),
            'report_type' => 'KPI',
            'port' => $this->port,
            'gmt_offset' => $this->gmt_offset,
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
            'food_total_incinerated' => $this->food_total_incinerated,
            'domestic_landed_ashore' => $this->domestic_landed_ashore,
            'domestic_incinerated' => $this->domestic_incinerated,
            'cooking_oil_landed_ashore' => $this->cooking_oil_landed_ashore,
            'cooking_oil_incinerated' => $this->cooking_oil_incinerated,
            'incinerator_ash_landed_ashore' => $this->incinerator_ash_landed_ashore,
            'incinerator_ash_incinerated' => $this->incinerator_ash_incinerated,
            'operational_landed_ashore' => $this->operational_landed_ashore,
            'operational_incinerated' => $this->operational_incinerated,
            'ewaste_landed_ashore' => $this->ewaste_landed_ashore,
            'ewaste_landed_total_incinerated' => $this->ewaste_landed_total_incinerated,
            'cargo_residues_landed_ashore' => $this->cargo_residues_landed_ashore,
            'cargo_residues_disposed_at_sea' => $this->cargo_residues_disposed_at_sea,
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

        Audit::create([
            'user'          => Auth::user()->name,
            'event'          => 'created_kpi_report',
            'old_values'     => [],
            'new_values'     => [
                'report_type' => $voyage->report_type,
            ],
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
        ]);

        Notification::create([
            'vessel_id' => $voyage->vessel_id,
            'text'      => "{$voyage->report_type} report has been created.",
        ]);

        ModelsVessel::where('id', $voyage->vessel_id)->increment('has_reports');

        Toaster::success('KPI Created Successfully.');
        $this->clearDraft();
        $this->clearForm();

        $this->redirect(TableKpiReport::class);
    }

    public function clearForm()
    {
        $this->clearDraft();

        // Voyage Information
        $this->all_fast_datetime = $this->port = $this->gmt_offset = $this->master_info = $this->remarks = null;

        // Waste Management
        $this->plastics_landed_ashore = $this->plastics_incinerated = null;
        $this->food_disposed_sea = $this->food_landed_ashore = null;
        $this->food_total_incinerated = null; // Added for total incinerated food
        $this->domestic_landed_ashore = $this->domestic_incinerated = null;
        $this->cooking_oil_landed_ashore = $this->cooking_oil_incinerated = null;
        $this->incinerator_ash_landed_ashore = $this->incinerator_ash_incinerated = null;
        $this->operational_landed_ashore = $this->operational_incinerated = null;
        $this->ewaste_landed_ashore = $this->cargo_residues_landed_ashore = null;
        $this->total_garbage_disposed_sea = $this->total_garbage_landed_ashore = null;
        $this->ewaste_landed_total_incinerated = $this->cargo_residues_disposed_at_sea = null; // Added for total incinerated ewaste and cargo residues
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
