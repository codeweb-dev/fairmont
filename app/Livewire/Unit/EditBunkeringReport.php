<?php

namespace App\Livewire\Unit;

use App\Models\Audit;
use App\Models\Notification;
use App\Models\Voyage;
use App\Models\Vessel as ModelsVessel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditBunkeringReport extends Component
{
    public $voyage;
    public $vesselName;

    // Fields (same as create)
    public $voyage_no;
    public $bunkering_port;
    public $supplier;
    public $port_etd;
    public $port_gmt_offset;
    public $bunker_completed;
    public $bunker_gmt_offset;

    public $hsfo_quantity;
    public $hsfo_viscosity;
    public $biofuel_quantity;
    public $biofuel_viscosity;
    public $vlsfo_quantity;
    public $vlsfo_viscosity;
    public $lsmgo_quantity;
    public $lsmgo_viscosity;

    public $port_delivery;
    public $eosp;
    public $eosp_gmt;
    public $barge;
    public $barge_gmt;
    public $cosp;
    public $cosp_gmt;
    public $anchor;
    public $anchor_gmt;
    public $pumping;
    public $pumping_gmt;

    public $remarks;
    public $master_info;

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
        $this->voyage = Voyage::with(['bunker', 'remarks', 'master_info', 'assiociated_information'])
            ->findOrFail($id);

        $this->vesselName = $this->voyage->vessel->name;

        // Fill properties from DB
        $this->voyage_no = $this->voyage->voyage_no;
        $this->bunkering_port = $this->voyage->bunkering_port;
        $this->supplier = $this->voyage->supplier;
        $this->port_etd = $this->voyage->port_etd;
        $this->port_gmt_offset = $this->voyage->port_gmt_offset;
        $this->bunker_completed = $this->voyage->bunker_completed;
        $this->bunker_gmt_offset = $this->voyage->bunker_gmt_offset;

        if ($this->voyage->bunker) {
            $this->hsfo_quantity = $this->voyage->bunker->hsfo_quantity;
            $this->hsfo_viscosity = $this->voyage->bunker->hsfo_viscosity;
            $this->biofuel_quantity = $this->voyage->bunker->biofuel_quantity;
            $this->biofuel_viscosity = $this->voyage->bunker->biofuel_viscosity;
            $this->vlsfo_quantity = $this->voyage->bunker->vlsfo_quantity;
            $this->vlsfo_viscosity = $this->voyage->bunker->vlsfo_viscosity;
            $this->lsmgo_quantity = $this->voyage->bunker->lsmgo_quantity;
            $this->lsmgo_viscosity = $this->voyage->bunker->lsmgo_viscosity;
        }

        if ($this->voyage->assiociated_information) {
            $info = $this->voyage->assiociated_information;
            $this->port_delivery = $info->port_delivery;
            $this->eosp = $info->eosp;
            $this->eosp_gmt = $info->eosp_gmt;
            $this->barge = $info->barge;
            $this->barge_gmt = $info->barge_gmt;
            $this->cosp = $info->cosp;
            $this->cosp_gmt = $info->cosp_gmt;
            $this->anchor = $info->anchor;
            $this->anchor_gmt = $info->anchor_gmt;
            $this->pumping = $info->pumping;
            $this->pumping_gmt = $info->pumping_gmt;
        }

        $this->remarks = $this->voyage->remarks->remarks ?? null;
        $this->master_info = $this->voyage->master_info->master_info ?? null;
    }

    public function update()
    {
        $this->validate([
            'voyage_no' => 'required|string|max:50',
            'bunkering_port' => 'required|string|max:255',
            'supplier' => 'required|string|max:255',
            'port_etd' => 'required|date',
            'port_gmt_offset' => 'required|string',
            'bunker_completed' => 'required|date',
            'bunker_gmt_offset' => 'required|string',
            'remarks' => 'nullable|string|max:5000',
            'master_info' => 'nullable|string|max:5000',
        ]);

        $oldValues = $this->voyage->toArray();

        // Update Voyage
        $this->voyage->update([
            'voyage_no' => $this->voyage_no,
            'bunkering_port' => $this->bunkering_port,
            'supplier' => $this->supplier,
            'port_etd' => $this->port_etd,
            'port_gmt_offset' => $this->port_gmt_offset,
            'bunker_completed' => $this->bunker_completed,
            'bunker_gmt_offset' => $this->bunker_gmt_offset,
        ]);

        // Update Relations
        $this->voyage->bunker()->updateOrCreate([], [
            'hsfo_quantity' => $this->hsfo_quantity,
            'hsfo_viscosity' => $this->hsfo_viscosity,
            'biofuel_quantity' => $this->biofuel_quantity,
            'biofuel_viscosity' => $this->biofuel_viscosity,
            'vlsfo_quantity' => $this->vlsfo_quantity,
            'vlsfo_viscosity' => $this->vlsfo_viscosity,
            'lsmgo_quantity' => $this->lsmgo_quantity,
            'lsmgo_viscosity' => $this->lsmgo_viscosity,
        ]);

        $this->voyage->assiociated_information()->updateOrCreate([], [
            'port_delivery' => $this->port_delivery,
            'eosp' => $this->eosp,
            'eosp_gmt' => $this->eosp_gmt,
            'barge' => $this->barge,
            'barge_gmt' => $this->barge_gmt,
            'cosp' => $this->cosp,
            'cosp_gmt' => $this->cosp_gmt,
            'anchor' => $this->anchor,
            'anchor_gmt' => $this->anchor_gmt,
            'pumping' => $this->pumping,
            'pumping_gmt' => $this->pumping_gmt,
        ]);

        $this->voyage->remarks()->updateOrCreate([], [
            'remarks' => $this->remarks,
        ]);

        $this->voyage->master_info()->updateOrCreate([], [
            'master_info' => $this->master_info,
        ]);

        Audit::create([
            'user'       => Auth::user()->name,
            'event'      => 'updated_bunkering_report',
            'old_values' => $oldValues,
            'new_values' => $this->voyage->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Notification::create([
            'vessel_id' => $this->voyage->vessel_id,
            'text'      => "Bunkering report has been updated.",
        ]);

        Toaster::success('Bunkering Report Updated Successfully.');
        return redirect()->route('table-bunkering-report');
    }

    public function render()
    {
        return view('livewire.unit.edit-bunkering-report');
    }
}
