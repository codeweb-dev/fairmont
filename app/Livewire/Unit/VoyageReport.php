<?php

namespace App\Livewire\Unit;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use App\Models\Voyage;

class VoyageReport extends Component
{
    public $vessel_id;
    public $voyage_no;
    public $all_fast_datetime;

    public $port_departure;
    public $port_arrival;

    public $hire_hours;
    public $hire_reason;

    public $remarks;
    public $master_info;

    // Engine data
    public $avg_me_rpm;
    public $avg_me_kw;
    public $tdr;
    public $tst;
    public $slip;

    // Received data
    public $received = [
        'hsfo' => null,
        'biofuel' => null,
        'vlsfo' => null,
        'lsmgo' => null,
        'me_cc_oil' => null,
        'mc_cyl_oil' => null,
        'ge_cc_oil' => null,
        'fw' => null,
        'fw_produced' => null,
    ];

    // ROBs data
    public $robs = [
        'hsfo' => null,
        'biofuel' => null,
        'vlsfo' => null,
        'lsmgo' => null,
        'me_cc_oil' => null,
        'mc_cyl_oil' => null,
        'ge_cc_oil' => null,
        'fw' => null,
        'fw_produced' => null,
    ];

    // Consumption data
    public $consumption = [
        'hsfo' => null,
        'biofuel' => null,
        'vlsfo' => null,
        'lsmgo' => null,
        'me_cc_oil' => null,
        'mc_cyl_oil' => null,
        'ge_cc_oil' => null,
        'fw' => null,
        'fw_produced' => null,
    ];

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
    }

    public function save()
    {
        $this->validate([
            'vessel_id' => 'required|exists:vessels,id',
            'voyage_no' => 'required|string|max:50',
            'all_fast_datetime' => 'required|date',

            'port_departure' => 'required|string|max:100',
            'port_arrival' => 'required|string|max:100',

            'hire_hours' => 'nullable|numeric|min:0',
            'hire_reason' => 'nullable|string|max:255',

            'avg_me_rpm' => 'nullable|numeric',
            'avg_me_kw' => 'nullable|numeric',
            'tdr' => 'nullable|numeric',
            'tst' => 'nullable|numeric',
            'slip' => 'nullable|numeric',

            'remarks' => 'nullable|string|max:5000',
            'master_info' => 'nullable|string|max:5000',

            'received.*' => 'nullable|numeric',
            'robs.*' => 'nullable|numeric',
            'consumption.*' => 'nullable|numeric',
        ]);

        $voyage = Voyage::create([
            'vessel_id' => $this->vessel_id,
            'unit_id' => Auth::id(),
            'report_type' => 'Voyage Report',
            'voyage_no' => $this->voyage_no,
            'all_fast_datetime' => $this->all_fast_datetime,
        ]);

        $voyage->off_hire()->create([
            'hire_hours' => $this->hire_hours,
            'hire_reason' => $this->hire_reason,
        ]);

        $voyage->location()->create([
            'port_departure' => $this->port_departure,
            'port_arrival' => $this->port_arrival,
        ]);

        $voyage->engine()->create([
            'avg_me_rpm' => $this->avg_me_rpm,
            'avg_me_kw' => $this->avg_me_kw,
            'tdr' => $this->tdr,
            'tst' => $this->tst,
            'slip' => $this->slip,
        ]);

        $voyage->consumption()->create($this->consumption);
        $voyage->received()->create($this->received);
        $voyage->robs()->create($this->robs);
        $voyage->remarks()->create(['remarks' => $this->remarks]);
        $voyage->master_info()->create(['master_info' => $this->master_info]);

        Toaster::success('Voyage Report Created Successfully.');
        $this->clearForm();
    }

    public function clearForm()
    {
        $this->reset([
            'voyage_no',
            'all_fast_datetime',
            'remarks',
            'master_info',
            'port_departure',
            'port_arrival',
            'hire_hours',
            'hire_reason',
            'avg_me_rpm',
            'avg_me_kw',
            'tdr',
            'tst',
            'slip',
            'received',
            'robs',
            'consumption'
        ]);
    }

    public function render()
    {
        return view('livewire.unit.voyage-report');
    }
}
