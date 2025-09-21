<?php

namespace App\Livewire\Unit;

use App\Models\Audit;
use App\Models\Notification;
use App\Models\Voyage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditVoyageReport extends Component
{
    public $voyage;
    public $vesselName;

    public $voyage_no;
    public $all_fast_datetime;
    public $port_departure;
    public $port_arrival;
    public $hire_hours;
    public $hire_reason;
    public $remarks;
    public $master_info;
    public $avg_me_rpm;
    public $avg_me_kw;
    public $tdr;
    public $tst;
    public $slip;

    public $robs = [];
    public $received = [];
    public $consumption = [];

    public function mount($id)
    {
        $this->voyage = Voyage::with([
            'vessel',
            'off_hire',
            'location',
            'engine',
            'robs',
            'received',
            'consumption',
            'remarks',
            'master_info'
        ])->findOrFail($id);

        $user = Auth::user();
        $userVessel = $user->vessels()->first();

        if (!$userVessel || $this->voyage->vessel_id !== $userVessel->id) {
            abort(403, 'You are not authorized to edit this report.');
        }

        $this->vesselName = $this->voyage->vessel->name;

        $this->voyage_no        = $this->voyage->voyage_no;
        $this->all_fast_datetime = $this->voyage->all_fast_datetime;
        $this->port_departure   = optional($this->voyage->location)->port_departure;
        $this->port_arrival     = optional($this->voyage->location)->port_arrival;
        $this->hire_hours       = optional($this->voyage->off_hire)->hire_hours;
        $this->hire_reason      = optional($this->voyage->off_hire)->hire_reason;
        $this->avg_me_rpm       = optional($this->voyage->engine)->avg_me_rpm;
        $this->avg_me_kw        = optional($this->voyage->engine)->avg_me_kw;
        $this->tdr              = optional($this->voyage->engine)->tdr;
        $this->tst              = optional($this->voyage->engine)->tst;
        $this->slip             = optional($this->voyage->engine)->slip;
        $this->remarks          = optional($this->voyage->remarks)->remarks;
        $this->master_info      = optional($this->voyage->master_info)->master_info;
        $rob = $this->voyage->robs->first();
        $this->robs = $rob?->toArray() ?? [];
        $this->received         = $this->voyage->received?->toArray() ?? [];
        $this->consumption      = $this->voyage->consumption?->toArray() ?? [];
    }

    public function update()
    {
        $this->validate([
            'voyage_no' => 'required|string|max:50',
            'all_fast_datetime' => 'required|date',
        ]);

        $this->voyage->update([
            'voyage_no'        => $this->voyage_no,
            'all_fast_datetime' => $this->all_fast_datetime,
        ]);

        $this->voyage->off_hire()->updateOrCreate([], [
            'hire_hours' => $this->hire_hours,
            'hire_reason' => $this->hire_reason,
        ]);

        $this->voyage->location()->updateOrCreate([], [
            'port_departure' => $this->port_departure,
            'port_arrival' => $this->port_arrival,
        ]);

        $this->voyage->engine()->updateOrCreate([], [
            'avg_me_rpm' => $this->avg_me_rpm,
            'avg_me_kw' => $this->avg_me_kw,
            'tdr' => $this->tdr,
            'tst' => $this->tst,
            'slip' => $this->slip,
        ]);

        $this->voyage->robs()->updateOrCreate([], $this->robs);
        $this->voyage->received()->updateOrCreate([], $this->received);
        $this->voyage->consumption()->updateOrCreate([], $this->consumption);
        $this->voyage->remarks()->updateOrCreate([], ['remarks' => $this->remarks]);
        $this->voyage->master_info()->updateOrCreate([], ['master_info' => $this->master_info]);

        Notification::create([
            'vessel_id' => $this->voyage->vessel_id,
            'text'      => "{$this->voyage->report_type} report has been updated.",
        ]);

        Audit::create([
            'user'       => Auth::user()->name,
            'event'      => 'updated_voyage_report',
            'old_values' => [],
            'new_values' => ['report_type' => $this->voyage->report_type],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Toaster::success('Voyage Report Updated Successfully.');
        return redirect()->route('table-voyage-report');
    }

    public function render()
    {
        return view('livewire.unit.edit-voyage-report');
    }
}
