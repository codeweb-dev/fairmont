<?php

namespace App\Livewire\Unit;

use App\Models\Audit;
use App\Models\Notification;
use App\Models\Voyage;
use App\Models\Vessel as ModelsVessel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditArrivalReport extends Component
{
    public $voyageId;
    public $vessel_id;
    public $vesselName = null;

    public $master_info;
    public $remarks;

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

    // Voyage Details
    public $voyage_no;
    public $port_gmt_offset = ''; // as Arrival Type
    public $all_fast_datetime; // as Date/Time (LT)
    public $gmt_offset;
    public $port = "0° 0' 0'' N/S"; // Latitude
    public $bunkering_port = "0° 0' 0'' E/W"; // Longitude
    public $supplier; // Arrival Port

    public $call_sign; // Anchored Hours
    public $flag; // Drifting Hours

    // Details Since Last Report (noon)
    public $cp_ordered_speed;
    public $me_cons_cp_speed;
    public $obs_distance;
    public $steaming_time;
    public $avg_speed;
    public $distance_to_go;
    public $breakdown;
    public $maneuvering_hours;
    public $avg_rpm;
    public $engine_distance;
    public $next_port;
    public $avg_power;
    public $logged_distance;
    public $speed_through_water;
    public $course;

    public $condition;
    public $displacement;
    public $cargo_name;
    public $cargo_weight;
    public $ballast_weight;
    public $fresh_water;
    public $fwd_draft;
    public $aft_draft;
    public $gm;

    public array $rob_data = [
        'HSFO' => [
            'summary' => [
                'previous' => '',
                'current' => '',
                'me_propulsion' => '',
                'ae_cons' => '',
                'boiler_cons' => '',
                'incinerators' => '',
                'me_24' => '',
                'ae_24' => '',
                'total_cons' => '',
                // Lube
                'me_cyl_grade' => '',
                'me_cyl_qty' => '',
                'me_cyl_hrs' => '',
                'me_cyl_cons' => '',
                'me_cc_qty' => '',
                'me_cc_hrs' => '',
                'me_cc_cons' => '',
                'ae_cc_qty' => '',
                'ae_cc_hrs' => '',
                'ae_cc_cons' => '',
            ]
        ],
        'BIOFUEL' => [
            'summary' => [
                'previous' => '',
                'current' => '',
                'me_propulsion' => '',
                'ae_cons' => '',
                'boiler_cons' => '',
                'incinerators' => '',
                'me_24' => '',
                'ae_24' => '',
                'total_cons' => '',
                // Lube
                'me_cyl_grade' => '',
                'me_cyl_qty' => '',
                'me_cyl_hrs' => '',
                'me_cyl_cons' => '',
                'me_cc_qty' => '',
                'me_cc_hrs' => '',
                'me_cc_cons' => '',
                'ae_cc_qty' => '',
                'ae_cc_hrs' => '',
                'ae_cc_cons' => '',
            ]
        ],
        'VLSFO' => [
            'summary' => [
                'previous' => '',
                'current' => '',
                'me_propulsion' => '',
                'ae_cons' => '',
                'boiler_cons' => '',
                'incinerators' => '',
                'me_24' => '',
                'ae_24' => '',
                'total_cons' => '',
                // Lube
                'me_cyl_grade' => '',
                'me_cyl_qty' => '',
                'me_cyl_hrs' => '',
                'me_cyl_cons' => '',
                'me_cc_qty' => '',
                'me_cc_hrs' => '',
                'me_cc_cons' => '',
                'ae_cc_qty' => '',
                'ae_cc_hrs' => '',
                'ae_cc_cons' => '',
            ]
        ],
        'LSFO' => [
            'summary' => [
                'previous' => '',
                'current' => '',
                'me_propulsion' => '',
                'ae_cons' => '',
                'boiler_cons' => '',
                'incinerators' => '',
                'me_24' => '',
                'ae_24' => '',
                'total_cons' => '',
                // Lube
                'me_cyl_grade' => '',
                'me_cyl_qty' => '',
                'me_cyl_hrs' => '',
                'me_cyl_cons' => '',
                'me_cc_qty' => '',
                'me_cc_hrs' => '',
                'me_cc_cons' => '',
                'ae_cc_qty' => '',
                'ae_cc_hrs' => '',
                'ae_cc_cons' => '',
            ]
        ],
        'ULSFO' => [
            'summary' => [
                'previous' => '',
                'current' => '',
                'me_propulsion' => '',
                'ae_cons' => '',
                'boiler_cons' => '',
                'incinerators' => '',
                'me_24' => '',
                'ae_24' => '',
                'total_cons' => '',
                // Lube
                'me_cyl_grade' => '',
                'me_cyl_qty' => '',
                'me_cyl_hrs' => '',
                'me_cyl_cons' => '',
                'me_cc_qty' => '',
                'me_cc_hrs' => '',
                'me_cc_cons' => '',
                'ae_cc_qty' => '',
                'ae_cc_hrs' => '',
                'ae_cc_cons' => '',
            ]
        ],
        'VLSMGO' => [
            'summary' => [
                'previous' => '',
                'current' => '',
                'me_propulsion' => '',
                'ae_cons' => '',
                'boiler_cons' => '',
                'incinerators' => '',
                'me_24' => '',
                'ae_24' => '',
                'total_cons' => '',
                // Lube
                'me_cyl_grade' => '',
                'me_cyl_qty' => '',
                'me_cyl_hrs' => '',
                'me_cyl_cons' => '',
                'me_cc_qty' => '',
                'me_cc_hrs' => '',
                'me_cc_cons' => '',
                'ae_cc_qty' => '',
                'ae_cc_hrs' => '',
                'ae_cc_cons' => '',
            ]
        ],
        'LSMGO' => [
            'summary' => [
                'previous' => '',
                'current' => '',
                'me_propulsion' => '',
                'ae_cons' => '',
                'boiler_cons' => '',
                'incinerators' => '',
                'me_24' => '',
                'ae_24' => '',
                'total_cons' => '',
                // Lube
                'me_cyl_grade' => '',
                'me_cyl_qty' => '',
                'me_cyl_hrs' => '',
                'me_cyl_cons' => '',
                'me_cc_qty' => '',
                'me_cc_hrs' => '',
                'me_cc_cons' => '',
                'ae_cc_qty' => '',
                'ae_cc_hrs' => '',
                'ae_cc_cons' => '',
            ]
        ],
        'ULSMGO' => [
            'summary' => [
                'previous' => '',
                'current' => '',
                'me_propulsion' => '',
                'ae_cons' => '',
                'boiler_cons' => '',
                'incinerators' => '',
                'me_24' => '',
                'ae_24' => '',
                'total_cons' => '',
                // Lube
                'me_cyl_grade' => '',
                'me_cyl_qty' => '',
                'me_cyl_hrs' => '',
                'me_cyl_cons' => '',
                'me_cc_qty' => '',
                'me_cc_hrs' => '',
                'me_cc_cons' => '',
                'ae_cc_qty' => '',
                'ae_cc_hrs' => '',
                'ae_cc_cons' => '',
            ]
        ],
    ];

    protected $listeners = ['saveDraft'];

    public function mount($id)
    {
        $this->voyageId = $id;

        $voyage = Voyage::with(['vessel', 'rob_fuel_reports', 'noon_report', 'remarks', 'master_info'])
            ->findOrFail($id);

        $this->vessel_id = $voyage->vessel_id;
        $this->vesselName = $voyage->vessel?->name;

        $this->voyage_no = $voyage->voyage_no;
        $this->port_gmt_offset = $voyage->port_gmt_offset;
        $this->all_fast_datetime = $voyage->all_fast_datetime;
        $this->gmt_offset = $voyage->gmt_offset;
        $this->port = $voyage->port;
        $this->bunkering_port = $voyage->bunkering_port;
        $this->supplier = $voyage->supplier;
        $this->call_sign = $voyage->call_sign;
        $this->flag = $voyage->flag;

        $this->remarks = $voyage->remarks->remarks ?? $voyage->remarks?->text ?? null;
        $this->master_info = $voyage->master_info->master_info ?? $voyage->master_info?->text ?? null;

        if ($voyage->noon_report) {
            $nr = $voyage->noon_report;
            $this->cp_ordered_speed = $nr->cp_ordered_speed;
            $this->me_cons_cp_speed = $nr->me_cons_cp_speed;
            $this->obs_distance = $nr->obs_distance;
            $this->steaming_time = $nr->steaming_time;
            $this->avg_speed = $nr->avg_speed;
            $this->distance_to_go = $nr->distance_to_go;
            $this->breakdown = $nr->breakdown;
            $this->maneuvering_hours = $nr->maneuvering_hours;
            $this->avg_rpm = $nr->avg_rpm;
            $this->engine_distance = $nr->engine_distance;
            $this->next_port = $nr->next_port;
            $this->avg_power = $nr->avg_power;
            $this->logged_distance = $nr->logged_distance;
            $this->speed_through_water = $nr->speed_through_water;
            $this->course = $nr->course;
            $this->condition = $nr->condition;
            $this->displacement = $nr->displacement;
            $this->cargo_name = $nr->cargo_name;
            $this->cargo_weight = $nr->cargo_weight;
            $this->ballast_weight = $nr->ballast_weight;
            $this->fresh_water = $nr->fresh_water;
            $this->fwd_draft = $nr->fwd_draft;
            $this->aft_draft = $nr->aft_draft;
            $this->gm = $nr->gm;
        }

        foreach ($voyage->rob_fuel_reports as $row) {
            $fuel = strtoupper($row->fuel_type);
            if (! isset($this->rob_data[$fuel])) {
                $this->rob_data[$fuel] = ['summary' => []];
            }

            $summary = $row->toArray();
            unset($summary['id'], $summary['voyage_id'], $summary['fuel_type'], $summary['created_at'], $summary['updated_at']);
            $this->rob_data[$fuel]['summary'] = array_merge($this->rob_data[$fuel]['summary'] ?? [], $summary);
        }

        foreach ($this->rob_data as $k => $v) {
            if (! isset($this->rob_data[$k]['summary']) || ! is_array($this->rob_data[$k]['summary'])) {
                $this->rob_data[$k]['summary'] = [];
            }
        }
    }

    public function update()
    {
        $this->validate([
            'vessel_id' => 'required|exists:vessels,id',
            'voyage_no' => 'nullable|string',
            'all_fast_datetime' => 'nullable|date',
            'master_info' => 'nullable|string|max:5000',
            'remarks' => 'nullable|string|max:5000',
        ]);

        $voyage = Voyage::findOrFail($this->voyageId);

        $oldValues = $voyage->toArray();

        // update voyage base fields
        $voyage->update([
            'voyage_no' => $this->voyage_no,
            'port_gmt_offset' => $this->port_gmt_offset,
            'all_fast_datetime' => $this->all_fast_datetime,
            'gmt_offset' => $this->gmt_offset,
            'port' => $this->port,
            'bunkering_port' => $this->bunkering_port,
            'supplier' => $this->supplier,
            'call_sign' => $this->call_sign,
            'flag' => $this->flag,
        ]);

        $voyage->rob_fuel_reports()->delete();
        foreach ($this->rob_data as $fuelType => $data) {
            $summary = $data['summary'] ?? [];

            $hasData = collect($summary)->filter(function ($v) {
                return $v !== null && $v !== '';
            })->isNotEmpty();

            if ($hasData) {
                $createData = $summary;
                $createData['fuel_type'] = $fuelType;
                $voyage->rob_fuel_reports()->create($createData);
            }
        }

        $voyage->noon_report()->updateOrCreate([], [
            'cp_ordered_speed' => $this->cp_ordered_speed,
            'me_cons_cp_speed' => $this->me_cons_cp_speed,
            'obs_distance' => $this->obs_distance,
            'steaming_time' => $this->steaming_time,
            'avg_speed' => $this->avg_speed,
            'distance_to_go' => $this->distance_to_go,
            'breakdown' => $this->breakdown,
            'maneuvering_hours' => $this->maneuvering_hours,
            'avg_rpm' => $this->avg_rpm,
            'engine_distance' => $this->engine_distance,
            'next_port' => $this->next_port,
            'avg_power' => $this->avg_power,
            'logged_distance' => $this->logged_distance,
            'speed_through_water' => $this->speed_through_water,
            'course' => $this->course,
            'condition' => $this->condition,
            'displacement' => $this->displacement,
            'cargo_name' => $this->cargo_name,
            'cargo_weight' => $this->cargo_weight,
            'ballast_weight' => $this->ballast_weight,
            'fresh_water' => $this->fresh_water,
            'fwd_draft' => $this->fwd_draft,
            'aft_draft' => $this->aft_draft,
            'gm' => $this->gm,
        ]);

        $voyage->remarks()->updateOrCreate([], ['remarks' => $this->remarks]);
        $voyage->master_info()->updateOrCreate([], ['master_info' => $this->master_info]);

        Notification::create([
            'vessel_id' => $voyage->vessel_id,
            'text' => "{$voyage->report_type} report has been updated.",
        ]);

        Audit::create([
            'user' => Auth::user()->name,
            'event' => 'updated_arrival_report',
            'old_values' => $oldValues,
            'new_values' => $voyage->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Toaster::success('Arrival Report updated successfully!');
        return redirect()->route('table-arrival-report');
    }

    public function render()
    {
        return view('livewire.unit.edit-arrival-report');
    }
}
