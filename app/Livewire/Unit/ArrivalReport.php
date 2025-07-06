<?php

namespace App\Livewire\Unit;

use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use App\Models\Voyage;
use Illuminate\Support\Facades\Session;

class ArrivalReport extends Component
{
    public $vessel_id;

    public $master_info;
    public $remarks;
    public $vesselName = null;
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
    public $supplier; // as Arrival Port

    public $call_sign; // Anchored Hours
    public $flag; // Drifting Hours

    // Details Since Last Report
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
                'me_cyl_grade' => 'MT',
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
                'me_cyl_grade' => 'MT',
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
                'me_cyl_grade' => 'MT',
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
                'me_propulsion' => 'MT',
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

    public function updated($property)
    {
        $this->saveDraft(); // Auto-save on field change
    }

    public function saveDraft()
    {
        Session::put('arrival_report_draft_' . Auth::id(), $this->only(array_keys(get_object_vars($this))));
    }

    public function loadDraft()
    {
        $draft = Session::get('arrival_report_draft_' . Auth::id());

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
        $draftKey = 'arrival_report_draft_' . Auth::id();
        Session::forget($draftKey);
    }

    public function save()
    {
        $this->validate([
            'vessel_id' => 'required|exists:vessels,id',
            'master_info' => 'nullable|string|max:5000',
        ]);

        $hasRobSummary = collect($this->rob_data)->contains(function ($data) {
            return collect($data['summary'])->filter(fn($value) => !empty($value))->isNotEmpty();
        });

        if (!$hasRobSummary) {
            Toaster::error('At least one ROB summary field must be filled before submitting.');
            return;
        }

        $voyage = Voyage::create([
            'vessel_id' => $this->vessel_id,
            'unit_id' => Auth::id(),
            'report_type' => 'Arrival Report',
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

        Notification::create([
            'text' => "{$voyage->report_type} report has been created.",
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

        $voyage->remarks()->create(['remarks' => $this->remarks]);
        $voyage->master_info()->create(['master_info' => $this->master_info]);

        Toaster::success('Arrival Report Created Successfully.');
        $this->clearDraft();
        $this->clearForm();

        $this->redirect('/table-arrival-report');
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
            'call_sign',
            'flag',

            'cp_ordered_speed',
            'me_cons_cp_speed',
            'obs_distance',
            'steaming_time',

            'avg_speed',
            'distance_to_go',
            'breakdown',
            'maneuvering_hours',

            'avg_rpm',
            'engine_distance',
            'next_port',
            'avg_power',

            'logged_distance',
            'speed_through_water',
            'course',

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
        return view('livewire.unit.arrival-report');
    }
}
