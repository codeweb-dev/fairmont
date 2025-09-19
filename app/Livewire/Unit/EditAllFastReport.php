<?php

namespace App\Livewire\Unit;

use App\Models\Voyage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditAllFastReport extends Component
{
    public $voyage_id;

    public array $robs = [];
    public $voyage_no;
    public $all_fast_datetime;
    public $port;
    public $gmt_offset;
    public $remarks;
    public $master_info;
    public $vesselName = null;
    public $vessel_id;

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
        $user = Auth::user();
        $userVessel = $user->vessels()->first();

        $voyage = Voyage::with(['robs', 'remarks', 'master_info', 'vessel'])
            ->findOrFail($id);

        if (!$userVessel || $voyage->vessel_id !== $userVessel->id) {
            abort(403, 'You are not authorized to edit this report.');
        }

        $this->voyage_id = $voyage->id;
        $this->vessel_id = $voyage->vessel_id;
        $this->vesselName = $voyage->vessel->name;

        $this->voyage_no = $voyage->voyage_no;
        $this->all_fast_datetime = $voyage->all_fast_datetime;
        $this->port = $voyage->port;
        $this->gmt_offset = $voyage->gmt_offset;
        $this->remarks = $voyage->remarks->remarks ?? null;
        $this->master_info = $voyage->master_info->master_info ?? null;
        $this->robs = $voyage->robs->toArray();
    }

    public function update()
    {
        $this->validate([
            'voyage_no' => 'required|string|max:50',
            'all_fast_datetime' => 'required|date',
            'port' => 'required|string',
            'gmt_offset' => 'required|string',
            'master_info' => 'nullable|string|max:5000',
            'remarks' => 'nullable|string|max:5000',
        ]);

        $voyage = Voyage::findOrFail($this->voyage_id);
        $voyage->update([
            'voyage_no' => $this->voyage_no,
            'all_fast_datetime' => $this->all_fast_datetime,
            'port' => $this->port,
            'gmt_offset' => $this->gmt_offset,
        ]);

        $voyage->robs()->delete();
        foreach ($this->robs as $rob) {
            $voyage->robs()->create($rob);
        }

        $voyage->remarks()->updateOrCreate([], ['remarks' => $this->remarks]);
        $voyage->master_info()->updateOrCreate([], ['master_info' => $this->master_info]);

        Toaster::success('All Fast Report Updated Successfully.');
        return redirect()->route('table-all-fast-report');
    }

    public function addRow()
    {
        $this->robs[] = [
            'hsfo' => null,
            'biofuel' => null,
            'vlsfo' => null,
            'lsfo' => null,
            'ulsfo' => null,
            'vlsmgo' => null,
            'lsmgo' => null,
            'ulsmgo' => null,
        ];
    }

    public function removeRow($index)
    {
        unset($this->robs[$index]);
        $this->robs = array_values($this->robs);
    }

    public function render()
    {
        return view('livewire.unit.edit-all-fast-report');
    }
}
