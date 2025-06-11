<?php

namespace App\Livewire\Unit;

use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use App\Models\Voyage;

class NoonReport extends Component
{
    public $vessel_id;

    public $master_info;
    public $remarks;
    public $vesselName = null;

    // Voyage Details
    public $voyage_no;
    public $port_gmt_offset = ''; // as Report Type
    public $all_fast_datetime; // as Date/Time (LT)
    public $gmt_offset;
    public $port; // as Latitude
    public $bunkering_port; // as Longtitude
    public $supplier; // as Port of Departure

    public array $gmtOffsets = [];
    public array $directions = [];
    public array $winds = [];
    public array $seas = [];
    public array $robs = [];

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

        foreach (['HSFO', 'BIOFUEL', 'VLSFO', 'LSMGO'] as $type) {
            $this->robs[$type] = [];
            $this->addRobRow($type);
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

        $this->directions = [
            "0 - N",
            "22.5 - NNE",
            "45 - NE",
            "67.5 - ENE",
            "90 - E",
            "112.5 - ESE",
            "135 - SE",
            "157.5 - SSE",
            "180 - S",
            "202.5 - SSW",
            "225 - SW",
            "247.5 - WSW",
            "270 - W",
            "292.5 - WNW",
            "315 - NW",
            "337.5 - NNW",
        ];

        $this->winds = [
            "0 - Calm",
            "1 - Light Air",
            "2 - Light Air Breeze",
            "3 - Gentle Breeze",
            "4 - Moderate Breeze",
            "5 - Fresh Breeze",
            "6 - Strong Breeze",
            "7 - Near Gale",
            "8 - Gale",
            "9 - Strong Gale",
            "10 - Storm",
            "11 - Violent Storm",
            "12 - Hurricane",
        ];

        $this->seas = [
            "0 - (No Wave)",
            "1 - (0-0.1m)",
            "2 - (0.1-0.5m)",
            "3 - (0.5-1.25m)",
            "4 - (1.25-2.5m)",
            "5 - (2.5-4.0m)",
            "6 - (4.0-6.0m)",
            "7 - (6.0-9.0m)",
            "8 - (9.0-14.0m)",
            "9 - (14+m)",
        ];
    }

    public function addRobRow($type)
    {
        $this->robs[$type][] = [
            'tank_no' => '',
            'description' => '',
            'grade' => $type,
            'capacity' => '',
            'unit' => 'MT',
            'rob' => '',
            'supply_date' => '',
        ];
    }

    public function removeRobRow($type, $index)
    {
        unset($this->robs[$type][$index]);
        $this->robs[$type] = array_values($this->robs[$type]);
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
            'report_type' => 'Noon Report',
            'voyage_no' => $this->voyage_no,
            'port_gmt_offset' => $this->port_gmt_offset,
            'all_fast_datetime' => $this->all_fast_datetime,
            'gmt_offset' => $this->gmt_offset,
            'port' => $this->port,
            'bunkering_port' => $this->bunkering_port,
            'supplier' => $this->supplier,
        ]);

        Notification::create([
            'text' => "{$voyage->report_type} report has been created.",
        ]);

        $voyage->remarks()->create(['remarks' => $this->remarks]);
        $voyage->master_info()->create(['master_info' => $this->master_info]);

        Toaster::success('Noon Report Created Successfully.');
        $this->clearForm();
    }

    public function export()
    {
        Toaster::info('Export feature not implemented yet.');
    }

    public function clearForm()
    {
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
        ]);
    }

    public function render()
    {
        $bunkerTypes = ['HSFO', 'BIOFUEL', 'VLSFO', 'LSMGO'];

        return view('livewire.unit.noon-report', [
            'bunkerTypes' => $bunkerTypes,
        ]);
    }
}
