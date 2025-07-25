<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Waste extends Model
{
    use SoftDeletes;

    protected $fillable = [
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
        'hull_cleanings'
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
