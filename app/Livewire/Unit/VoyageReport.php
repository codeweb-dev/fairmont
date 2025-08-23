<?php

namespace App\Livewire\Unit;

use App\Models\Audit;
use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use App\Models\Voyage;
use Illuminate\Support\Facades\Session;

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

    protected $listeners = ['saveDraft', 'autoSave'];

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

    // public function updated($property)
    // {
    //     $this->saveDraft(); // Auto-save on property update
    // }

    public function autoSave()
    {
        $this->saveDraftToSession();
        // Toaster::success('Draft saved successfully!');
    }

    private function saveDraftToSession()
    {
        Session::put('voyage_draft_' . Auth::id(), $this->only(array_keys(get_object_vars($this))));
    }

    // public function saveDraft()
    // {
    //     $draft = [
    //         'voyage_no' => $this->voyage_no,
    //         'all_fast_datetime' => $this->all_fast_datetime,
    //         'remarks' => $this->remarks,
    //         'master_info' => $this->master_info,
    //         'port_departure' => $this->port_departure,
    //         'port_arrival' => $this->port_arrival,
    //         'hire_hours' => $this->hire_hours,
    //         'hire_reason' => $this->hire_reason,
    //         'avg_me_rpm' => $this->avg_me_rpm,
    //         'avg_me_kw' => $this->avg_me_kw,
    //         'tdr' => $this->tdr,
    //         'tst' => $this->tst,
    //         'slip' => $this->slip,
    //         'received' => $this->received,
    //         'robs' => $this->robs,
    //         'consumption' => $this->consumption,
    //         'saved_at' => now()->toDateTimeString(),
    //     ];

    //     Session::put('voyage_draft_' . Auth::id(), $draft);
    // }

    public function loadDraft()
    {
        $draft = Session::get('voyage_draft_' . Auth::id());

        if ($draft) {
            $this->voyage_no = $draft['voyage_no'] ?? null;
            $this->all_fast_datetime = $draft['all_fast_datetime'] ?? null;
            $this->remarks = $draft['remarks'] ?? null;
            $this->master_info = $draft['master_info'] ?? null;
            $this->port_departure = $draft['port_departure'] ?? null;
            $this->port_arrival = $draft['port_arrival'] ?? null;
            $this->hire_hours = $draft['hire_hours'] ?? null;
            $this->hire_reason = $draft['hire_reason'] ?? null;
            $this->avg_me_rpm = $draft['avg_me_rpm'] ?? null;
            $this->avg_me_kw = $draft['avg_me_kw'] ?? null;
            $this->tdr = $draft['tdr'] ?? null;
            $this->tst = $draft['tst'] ?? null;
            $this->slip = $draft['slip'] ?? null;
            $this->received = $draft['received'] ?? $this->received;
            $this->robs = $draft['robs'] ?? $this->robs;
            $this->consumption = $draft['consumption'] ?? $this->consumption;
        }
    }

    public function clearDraft()
    {
        $draftKey = 'voyage_draft_' . Auth::id();
        Session::forget($draftKey);
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
            'text' => "{$voyage->report_type} report has been created.",
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
            'auditable_id'   => $voyage->id,
            'auditable_type' => Voyage::class,
            'user_id'        => Auth::id(),
            'event'          => 'created_voyage_report',
            'old_values'     => [],
            'new_values'     => [
                'report_type' => $voyage->report_type,
            ],
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
        ]);

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
