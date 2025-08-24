<?php

namespace App\Livewire\Unit;

use App\Models\Audit;
use App\Models\Draft;
use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use App\Models\Voyage;

class DepartureReport extends Component
{
    public $vessel_id;

    public $master_info;
    public $remarks;
    public $vesselName;
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
    public $port_gmt_offset = ''; // as Arivval Type
    public $all_fast_datetime; // as Date/Time (LT)
    public $gmt_offset;
    public $port = "0° 0' 0'' N/S"; // as Latitude
    public $bunkering_port = "0° 0' 0'' E/W"; // as Longtitude
    public $supplier; // as Departure Port

    // Details Since Last Report
    public $cp_ordered_speed;
    public $me_cons_cp_speed;
    public $obs_distance;
    public $steaming_time;

    public $avg_speed;
    public $distance_to_go;
    public $breakdown;
    public $eta_gmt_offset;

    public $avg_rpm;
    public $engine_distance;
    public $maneuvering_hours;
    public $avg_power;

    public $logged_distance;
    public $speed_through_water;
    public $course;
    public $eta_next_port;

    public $next_port;

    // Noon Conditions
    public $condition;
    public $displacement;
    public $cargo_name;
    public $cargo_weight;
    public $ballast_weight;
    public $fresh_water;
    public $fwd_draft;
    public $aft_draft;
    public $gm;

    // Voyage Itinerary
    public $next_port_voyage;
    public $via;
    public $eta_lt;
    public $gmt_offset_voyage;
    public $distance_to_go_voyage;
    public $projected_speed;

    protected $listeners = ['saveDraft'];

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
    ];

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
                'type' => 'departure',
            ],
            [
                'data' => json_encode($this->only([
                    'remarks',
                    'master_info',

                    'voyage_no',
                    'port_gmt_offset',
                    'all_fast_datetime',
                    'gmt_offset',
                    'port',
                    'bunkering_port',
                    'supplier',

                    'cp_ordered_speed',
                    'me_cons_cp_speed',
                    'obs_distance',
                    'steaming_time',

                    'avg_speed',
                    'distance_to_go',
                    'breakdown',

                    'eta_next_port',
                    'next_port',

                    'avg_rpm',
                    'engine_distance',
                    'maneuvering_hours',
                    'avg_power',

                    'logged_distance',
                    'speed_through_water',
                    'course',

                    'next_port_voyage',
                    'via',
                    'eta_lt',
                    'gmt_offset_voyage',
                    'distance_to_go_voyage',
                    'projected_speed',

                    'condition',
                    'displacement',
                    'cargo_name',
                    'cargo_weight',
                    'ballast_weight',
                    'fresh_water',
                    'fwd_draft',
                    'aft_draft',
                    'gm',

                    'rob_data',
                ])),
            ]
        );

        $this->dispatch('draftSaved');
    }

    public function loadDraft()
    {
        $draft = Draft::where('user_id', Auth::id())
            ->where('type', 'departure')
            ->first();

        if ($draft) {
            $data = json_decode($draft->data, true);

            $this->remarks = $data['remarks'] ?? null;
            $this->master_info = $data['master_info'] ?? null;

            $this->voyage_no = $data['voyage_no'] ?? null;
            $this->port_gmt_offset = $data['port_gmt_offset'] ?? null;
            $this->all_fast_datetime = $data['all_fast_datetime'] ?? null;
            $this->gmt_offset = $data['gmt_offset'] ?? null;
            $this->port = $data['port'] ?? null;
            $this->bunkering_port = $data['bunkering_port'] ?? null;
            $this->supplier = $data['supplier'] ?? null;

            $this->cp_ordered_speed = $data['cp_ordered_speed'] ?? null;
            $this->me_cons_cp_speed = $data['me_cons_cp_speed'] ?? null;
            $this->obs_distance = $data['obs_distance'] ?? null;
            $this->steaming_time = $data['steaming_time'] ?? null;

            $this->avg_speed = $data['avg_speed'] ?? null;
            $this->distance_to_go = $data['distance_to_go'] ?? null;
            $this->breakdown = $data['breakdown'] ?? null;

            $this->eta_next_port = $data['eta_next_port'] ?? null;
            $this->next_port = $data['next_port'] ?? null;

            $this->avg_rpm = $data['avg_rpm'] ?? null;
            $this->engine_distance = $data['engine_distance'] ?? null;
            $this->maneuvering_hours = $data['maneuvering_hours'] ?? null;
            $this->avg_power = $data['avg_power'] ?? null;

            $this->logged_distance = $data['logged_distance'] ?? null;
            $this->speed_through_water = $data['speed_through_water'] ?? null;
            $this->course = $data['course'] ?? null;

            $this->next_port_voyage = $data['next_port_voyage'] ?? null;
            $this->via = $data['via'] ?? null;
            $this->eta_lt = $data['eta_lt'] ?? null;
            $this->gmt_offset_voyage = $data['gmt_offset_voyage'] ?? null;
            $this->distance_to_go_voyage = $data['distance_to_go_voyage'] ?? null;
            $this->projected_speed = $data['projected_speed'] ?? null;

            $this->condition = $data['condition'] ?? null;
            $this->displacement = $data['displacement'] ?? null;
            $this->cargo_name = $data['cargo_name'] ?? null;
            $this->cargo_weight = $data['cargo_weight'] ?? null;
            $this->ballast_weight = $data['ballast_weight'] ?? null;
            $this->fresh_water = $data['fresh_water'] ?? null;
            $this->fwd_draft = $data['fwd_draft'] ?? null;
            $this->aft_draft = $data['aft_draft'] ?? null;
            $this->gm = $data['gm'] ?? null;

            $this->rob_data = $data['rob_data'] ?? [];
        }
    }

    public function clearDraft()
    {
        Draft::where('user_id', Auth::id())
            ->where('type', 'departure')
            ->delete();
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
            'report_type' => 'Departure Report',
            'voyage_no' => $this->voyage_no,
            'port_gmt_offset' => $this->port_gmt_offset,
            'all_fast_datetime' => $this->all_fast_datetime,
            'gmt_offset' => $this->gmt_offset,
            'port' => $this->port,
            'bunkering_port' => $this->bunkering_port,
            'supplier' => $this->supplier,
        ]);

        Notification::create([
            'vessel_id' => $voyage->vessel_id,
            'text'      => "{$voyage->report_type} report has been created.",
        ]);

        foreach ($this->rob_data as $fuelType => $data) {
            $hasSummaryData = collect($data['summary'])->filter(fn($value) => !empty($value));

            if ($hasSummaryData->isNotEmpty()) {
                $voyage->rob_fuel_reports()->create(array_merge(
                    $data['summary'],
                    ['fuel_type' => $fuelType]
                ));
            }
        }

        $voyage->noon_report()->create([
            'cp_ordered_speed' => $this->cp_ordered_speed,
            'me_cons_cp_speed' => $this->me_cons_cp_speed,
            'obs_distance' => $this->obs_distance,
            'steaming_time' => $this->steaming_time,

            'avg_speed' => $this->avg_speed,
            'distance_to_go' => $this->distance_to_go,
            'maneuvering_hours' => $this->maneuvering_hours,
            'eta_gmt_offset' => $this->eta_gmt_offset,

            'avg_rpm' => $this->avg_rpm,
            'engine_distance' => $this->engine_distance,
            'avg_power' => $this->avg_power,

            'logged_distance' => $this->logged_distance,
            'speed_through_water' => $this->speed_through_water,
            'course' => $this->course,
            'eta_next_port' => $this->eta_next_port,

            'next_port' => $this->next_port,

            'condition' => $this->condition,
            'displacement' => $this->displacement,
            'cargo_name' => $this->cargo_name,
            'cargo_weight' => $this->cargo_weight,
            'ballast_weight' => $this->ballast_weight,
            'fresh_water' => $this->fresh_water,
            'fwd_draft' => $this->fwd_draft,
            'aft_draft' => $this->aft_draft,
            'gm' => $this->gm,

            // Voyage Itinerary
            'next_port_voyage' => $this->next_port_voyage,
            'via' => $this->via,
            'eta_lt' => $this->eta_lt,
            'gmt_offset_voyage' => $this->gmt_offset_voyage,
            'distance_to_go_voyage' => $this->distance_to_go_voyage,
            'projected_speed' => $this->projected_speed,
        ]);

        $voyage->remarks()->create(['remarks' => $this->remarks]);
        $voyage->master_info()->create(['master_info' => $this->master_info]);

        Audit::create([
            'auditable_id'   => $voyage->id,
            'auditable_type' => Voyage::class,
            'user_id'        => Auth::id(),
            'event'          => 'created_departure_report',
            'old_values'     => [],
            'new_values'     => [
                'report_type' => $voyage->report_type,
            ],
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
        ]);

        Toaster::success('Departure Report Created Successfully.');
        $this->clearDraft();
        $this->clearForm();

        $this->redirect('/table-departure-report');
    }

    public function clearForm()
    {
        $this->clearDraft();

        $this->reset([
            'remarks',
            'master_info',

            'voyage_no',
            'port_gmt_offset',
            'all_fast_datetime',
            'gmt_offset',
            'port',
            'bunkering_port',
            'supplier',

            'cp_ordered_speed',
            'me_cons_cp_speed',
            'obs_distance',
            'steaming_time',

            'avg_speed',
            'distance_to_go',
            'breakdown',

            'eta_next_port',
            'next_port',

            'avg_rpm',
            'engine_distance',
            'maneuvering_hours',
            'avg_power',

            'logged_distance',
            'speed_through_water',
            'course',

            'next_port_voyage',
            'via',
            'eta_lt',
            'gmt_offset_voyage',
            'distance_to_go_voyage',
            'projected_speed',

            'condition',
            'displacement',
            'cargo_name',
            'cargo_weight',
            'ballast_weight',
            'fresh_water',
            'fwd_draft',
            'aft_draft',
            'gm',

            'rob_data',
        ]);
    }

    public function render()
    {
        return view('livewire.unit.departure-report');
    }
}
