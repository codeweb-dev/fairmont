<?php

namespace App\Livewire\Unit;

use App\Models\Audit;
use App\Models\Notification;
use App\Models\Voyage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditDepartureReport extends Component
{
    public $voyage_id;
    public $vessel_id;
    public $vesselName;

    // Main fields
    public $voyage_no, $all_fast_datetime, $gmt_offset, $port, $bunkering_port, $supplier, $port_gmt_offset;

    // Noon report fields
    public $cp_ordered_speed, $obs_distance, $steaming_time, $avg_speed, $distance_to_go, $avg_rpm;
    public $engine_distance, $maneuvering_hours, $avg_power, $course, $logged_distance, $speed_through_water;
    public $next_port, $eta_next_port, $eta_gmt_offset;
    public $condition, $displacement, $cargo_name, $cargo_weight, $ballast_weight, $fresh_water, $fwd_draft, $aft_draft, $gm;
    public $next_port_voyage, $via, $eta_lt, $gmt_offset_voyage, $distance_to_go_voyage, $projected_speed;

    // Remarks & master info
    public $remarks, $master_info;

    // ROB data (fuel reports)
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

    public function mount($id)
    {
        $voyage = Voyage::with(['rob_fuel_reports', 'noon_report', 'remarks', 'master_info', 'vessel'])
            ->findOrFail($id);

        $this->voyage_id  = $voyage->id;
        $this->vessel_id  = $voyage->vessel_id;
        $this->vesselName = $voyage->vessel->name ?? '';

        // Fill main voyage data
        $this->voyage_no         = $voyage->voyage_no;
        $this->all_fast_datetime = $voyage->all_fast_datetime;
        $this->gmt_offset        = $voyage->gmt_offset;
        $this->port              = $voyage->port;
        $this->bunkering_port    = $voyage->bunkering_port;
        $this->supplier          = $voyage->supplier;
        $this->port_gmt_offset   = $voyage->port_gmt_offset;

        // Fill noon report data
        if ($voyage->noon_report) {
            foreach ($voyage->noon_report->getAttributes() as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }

        // Remarks & master info
        $this->remarks     = $voyage->remarks->remarks ?? null;
        $this->master_info = $voyage->master_info->master_info ?? null;

        // ROB fuel reports
        foreach ($voyage->rob_fuel_reports as $row) {
            $fuel = strtoupper($row->fuel_type);
            if (! isset($this->rob_data[$fuel])) {
                $this->rob_data[$fuel] = ['summary' => []];
            }

            $summary = $row->toArray();
            unset($summary['id'], $summary['voyage_id'], $summary['fuel_type'], $summary['created_at'], $summary['updated_at']);

            $this->rob_data[$fuel]['summary'] = array_merge($this->rob_data[$fuel]['summary'] ?? [], $summary);
        }

        foreach ($this->rob_data as $fuel => $data) {
            if (! isset($data['summary']) || ! is_array($data['summary'])) {
                $this->rob_data[$fuel]['summary'] = [];
            }
        }
    }

    public function update()
    {
        $voyage = Voyage::findOrFail($this->voyage_id);

        // Update voyage base fields
        $voyage->update([
            'voyage_no'        => $this->voyage_no,
            'all_fast_datetime' => $this->all_fast_datetime,
            'gmt_offset'       => $this->gmt_offset,
            'port'             => $this->port,
            'bunkering_port'   => $this->bunkering_port,
            'supplier'         => $this->supplier,
            'port_gmt_offset'  => $this->port_gmt_offset,
        ]);

        // Update ROB fuel reports
        $voyage->rob_fuel_reports()->delete();
        foreach ($this->rob_data as $fuelType => $data) {
            $hasSummaryData = collect($data['summary'])->filter(fn($value) => !empty($value));
            if ($hasSummaryData->isNotEmpty()) {
                $voyage->rob_fuel_reports()->create(array_merge(
                    $data['summary'],
                    ['fuel_type' => $fuelType]
                ));
            }
        }

        // Update Noon Report
        $voyage->noon_report()->updateOrCreate([], [
            'cp_ordered_speed'   => $this->cp_ordered_speed,
            'obs_distance'       => $this->obs_distance,
            'steaming_time'      => $this->steaming_time,
            'avg_speed'          => $this->avg_speed,
            'distance_to_go'     => $this->distance_to_go,
            'avg_rpm'            => $this->avg_rpm,
            'engine_distance'    => $this->engine_distance,
            'maneuvering_hours'  => $this->maneuvering_hours,
            'avg_power'          => $this->avg_power,
            'course'             => $this->course,
            'logged_distance'    => $this->logged_distance,
            'speed_through_water' => $this->speed_through_water,
            'next_port'          => $this->next_port,
            'eta_next_port'      => $this->eta_next_port,
            'eta_gmt_offset'     => $this->eta_gmt_offset,
            'condition'          => $this->condition,
            'displacement'       => $this->displacement,
            'cargo_name'         => $this->cargo_name,
            'cargo_weight'       => $this->cargo_weight,
            'ballast_weight'     => $this->ballast_weight,
            'fresh_water'        => $this->fresh_water,
            'fwd_draft'          => $this->fwd_draft,
            'aft_draft'          => $this->aft_draft,
            'gm'                 => $this->gm,
            'next_port_voyage'   => $this->next_port_voyage,
            'via'                => $this->via,
            'eta_lt'             => $this->eta_lt,
            'gmt_offset_voyage'  => $this->gmt_offset_voyage,
            'distance_to_go_voyage' => $this->distance_to_go_voyage,
            'projected_speed'    => $this->projected_speed,
        ]);

        // Update remarks & master info
        $voyage->remarks()->updateOrCreate([], ['remarks' => $this->remarks]);
        $voyage->master_info()->updateOrCreate([], ['master_info' => $this->master_info]);

        // Notification + Audit
        Notification::create([
            'vessel_id' => $voyage->vessel_id,
            'text'      => "{$voyage->report_type} report has been updated.",
        ]);

        Audit::create([
            'user'       => Auth::user()->name,
            'event'      => 'updated_departure_report',
            'old_values' => [],
            'new_values' => ['report_type' => $voyage->report_type],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Toaster::success('Departure report updated successfully!');
        return redirect()->route('table-departure-report');
    }

    public function render()
    {
        return view('livewire.unit.edit-departure-report');
    }
}
