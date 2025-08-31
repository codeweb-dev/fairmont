<?php

namespace App\Livewire\Unit;

use App\Models\Audit;
use App\Models\Draft;
use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use App\Models\Voyage;
use App\Models\Vessel as ModelsVessel;

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

    public function autoSave()
    {
        $this->saveDraftToDatabase();
    }

    private function saveDraftToDatabase()
    {
        $data = [
            'vessel_id'        => $this->vessel_id,
            'voyage_no'        => $this->voyage_no,
            'all_fast_datetime' => $this->all_fast_datetime,
            'remarks'          => $this->remarks,
            'master_info'      => $this->master_info,
            'port_departure'   => $this->port_departure,
            'port_arrival'     => $this->port_arrival,
            'hire_hours'       => $this->hire_hours,
            'hire_reason'      => $this->hire_reason,
            'avg_me_rpm'       => $this->avg_me_rpm,
            'avg_me_kw'        => $this->avg_me_kw,
            'tdr'              => $this->tdr,
            'tst'              => $this->tst,
            'slip'             => $this->slip,
            'received'         => $this->received,
            'robs'             => $this->robs,
            'consumption'      => $this->consumption,
        ];

        Draft::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'type'    => 'voyage',
            ],
            [
                'data' => json_encode($data),
            ]
        );

        $this->dispatch('draftSaved');
    }

    public function loadDraft()
    {
        $draft = Draft::where('user_id', Auth::id())
            ->where('type', 'voyage')
            ->first();

        if ($draft) {
            $data = json_decode($draft->data, true);

            $this->voyage_no        = $data['voyage_no'] ?? null;
            $this->all_fast_datetime = $data['all_fast_datetime'] ?? null;
            $this->remarks          = $data['remarks'] ?? null;
            $this->master_info      = $data['master_info'] ?? null;
            $this->port_departure   = $data['port_departure'] ?? null;
            $this->port_arrival     = $data['port_arrival'] ?? null;
            $this->hire_hours       = $data['hire_hours'] ?? null;
            $this->hire_reason      = $data['hire_reason'] ?? null;
            $this->avg_me_rpm       = $data['avg_me_rpm'] ?? null;
            $this->avg_me_kw        = $data['avg_me_kw'] ?? null;
            $this->tdr              = $data['tdr'] ?? null;
            $this->tst              = $data['tst'] ?? null;
            $this->slip             = $data['slip'] ?? null;
            $this->received         = $data['received'] ?? $this->received;
            $this->robs             = $data['robs'] ?? $this->robs;
            $this->consumption      = $data['consumption'] ?? $this->consumption;
        }
    }

    public function clearDraft()
    {
        Draft::where('user_id', Auth::id())
            ->where('type', 'voyage_report')
            ->delete();
    }

    public function save()
    {
        $this->validate([
            'vessel_id' => 'required|exists:vessels,id',
            'voyage_no' => 'required|string|max:50',
            'all_fast_datetime' => 'required|date',

            'port_departure' => 'nullable|string|max:100',
            'port_arrival' => 'nullable|string|max:100',

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

        Notification::create([
            'vessel_id' => $voyage->vessel_id,
            'text'      => "{$voyage->report_type} report has been created.",
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

        Audit::create([
            'user'          => Auth::user()->name,
            'event'          => 'created_voyage_report',
            'old_values'     => [],
            'new_values'     => [
                'report_type' => $voyage->report_type,
            ],
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
        ]);

        ModelsVessel::where('id', $voyage->vessel_id)->increment('has_reports');

        Toaster::success('Voyage Report Created Successfully.');
        $this->clearDraft();
        $this->clearForm();

        $this->redirect('/table-voyage-report');
    }

    public function clearForm()
    {
        $this->clearDraft();

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
