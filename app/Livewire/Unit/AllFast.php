<?php

namespace App\Livewire\Unit;

use App\Models\Notification;
use App\Models\User;
use App\Models\Voyage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class AllFast extends Component
{
    public array $robs = [];

    public $vessel_id;
    public $voyage_no;
    public $all_fast_datetime;
    public $port;
    public $gmt_offset;

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

    public function mount()
    {
        $this->addRow();

        $user = Auth::user();
        $vessel = $user->vessels()->first();

        if ($vessel) {
            $this->vessel_id = $vessel->id;
            $this->vesselName = $vessel->name;
        } else {
            return redirect()->route('unassigned');
        }
    }

    public function addRow()
    {
        $this->robs[] = [
            'hsfo' => null,
            'biofuel' => null,
            'vlsfo' => null,
            'lsmgo' => null,
        ];
    }

    public function removeRow($index)
    {
        unset($this->robs[$index]);
        $this->robs = array_values($this->robs);
    }

    public function export()
    {
        Toaster::info('Export feature not implemented yet.');
    }

    public function save()
    {
        $this->validate([
            'vessel_id' => 'required|exists:vessels,id',
            'voyage_no' => 'required|string|max:50',
            'all_fast_datetime' => 'required|date',
            'port' => 'required|string',
            'gmt_offset' => 'required|string',
        ]);

        $voyage = Voyage::create([
            'vessel_id' => $this->vessel_id,
            'unit_id' => Auth::id(),
            'report_type' => 'All Fast',
            'voyage_no' => $this->voyage_no,
            'all_fast_datetime' => $this->all_fast_datetime,
            'port' => $this->port,
            'gmt_offset' => $this->gmt_offset,
        ]);

        Notification::create([
            'text' => "{$voyage->report_type} report has been created.",
        ]);

        foreach ($this->robs as $rob) {
            $voyage->robs()->create($rob);
        }

        Toaster::success('All Fast Report Created Successfully.');
        $this->clearForm();
    }

    public function clearForm()
    {
        $this->reset([
            'voyage_no',
            'all_fast_datetime',
            'port',
            'gmt_offset',
            'robs',
        ]);
        $this->addRow();
    }

    public function render()
    {
        return view('livewire.unit.all-fast');
    }
}
