<?php

namespace App\Livewire\Unit;

use App\Models\Audit;
use App\Models\Notification;
use App\Models\Voyage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditKpiReport extends Component
{
    public $voyage_id;
    public $vessel_id;
    public $vesselName = null;

    public $all_fast_datetime;
    public $port;
    public $gmt_offset;

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

    public $master_info;
    public $remarks;

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

    public function mount($id)
    {
        $user = Auth::user();
        $voyage = Voyage::with(['waste', 'remarks', 'master_info', 'vessel'])->findOrFail($id);

        if (!$user->vessels->contains($voyage->vessel_id)) {
            abort(403, 'Unauthorized.');
        }

        $this->voyage_id = $voyage->id;
        $this->vessel_id = $voyage->vessel_id;
        $this->vesselName = $voyage->vessel->name;

        foreach ($voyage->getAttributes() as $field => $value) {
            if (property_exists($this, $field)) {
                $this->$field = $value;
            }
        }

        if ($voyage->waste) {
            foreach ($voyage->waste->getAttributes() as $field => $value) {
                if (property_exists($this, $field)) {
                    $this->$field = $value;
                }
            }
        }

        $this->remarks = $voyage->remarks->remarks ?? null;
        $this->master_info = $voyage->master_info->master_info ?? null;
    }

    public function update()
    {
        $this->validate([
            'all_fast_datetime' => 'required|date',
            'port' => 'required|string',
            'gmt_offset' => 'required|string',
        ]);

        $voyage = Voyage::findOrFail($this->voyage_id);

        $voyage->update([
            'all_fast_datetime' => $this->all_fast_datetime,
            'port' => $this->port,
            'gmt_offset' => $this->gmt_offset,
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
        ]);

        $voyage->waste()->updateOrCreate([], [
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

        $voyage->remarks()->updateOrCreate([], ['remarks' => $this->remarks]);
        $voyage->master_info()->updateOrCreate([], ['master_info' => $this->master_info]);

        Notification::create([
            'vessel_id' => $voyage->vessel_id,
            'text'      => "{$voyage->report_type} report has been updated.",
        ]);

        Audit::create([
            'user'       => Auth::user()->name,
            'event'      => 'updated_kpi_report',
            'old_values' => [],
            'new_values' => ['report_type' => $voyage->report_type],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Toaster::success('KPI Report Updated Successfully.');
        return redirect()->route('table-kpi-report');
    }

    public function render()
    {
        return view('livewire.unit.edit-kpi-report');
    }
}
