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

class WeeklySchedule extends Component
{
    public $vessel_id;
    public $voyage_no;
    public $all_fast_datetime; // all_fast_datetime as date here
    public $ports = [];

    public $remarks;
    public $master_info;

    public $vesselName = null;
    protected $listeners = ['saveDraft'];

    public function autoSave()
    {
        $this->saveDraftToDatabase();
    }

    private function saveDraftToDatabase()
    {
        $data = [
            'vessel_id'         => $this->vessel_id,
            'voyage_no'         => $this->voyage_no,
            'all_fast_datetime' => $this->all_fast_datetime,
            'ports'             => $this->ports,
            'remarks'           => $this->remarks,
            'master_info'       => $this->master_info,
        ];

        Draft::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'type'    => 'weekly_schedule',
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
            ->where('type', 'weekly_schedule')
            ->first();

        if ($draft) {
            $data = json_decode($draft->data, true);

            $this->voyage_no         = $data['voyage_no'] ?? null;
            $this->all_fast_datetime = $data['all_fast_datetime'] ?? null;
            $this->remarks           = $data['remarks'] ?? null;
            $this->master_info       = $data['master_info'] ?? null;
            $this->ports             = $data['ports'] ?? [];
        }
    }

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

        if (empty($this->ports)) {
            $this->addPort();
        }
    }

    public function save()
    {
        $this->validate([
            'vessel_id' => 'required|exists:vessels,id',
            'voyage_no' => 'required|string',
            'all_fast_datetime' => 'required|date',
            'master_info' => 'nullable|string|max:5000',
            'remarks' => 'nullable|string|max:5000',
        ]);

        $vessel = ModelsVessel::findOrFail($this->vessel_id);

        if (!$vessel->is_active) {
            Toaster::error('This vessel has been deactivated. It will no longer be available for new reports.');
            return;
        }

        $voyage = Voyage::create([
            'vessel_id' => $this->vessel_id,
            'unit_id' => Auth::id(),
            'report_type' => 'Weekly Schedule',
            'voyage_no' => $this->voyage_no,
            'all_fast_datetime' => $this->all_fast_datetime,
        ]);

        Notification::create([
            'vessel_id' => $voyage->vessel_id,
            'text'      => "{$voyage->report_type} report has been created.",
        ]);

        foreach ($this->ports as $portData) {
            $port = $voyage->ports()->create($portData);

            foreach ($portData['agents'] as $agentData) {
                $port->agents()->create($agentData);
            }
        }

        Toaster::success('Weekly Schedule Created Successfully.');
        $voyage->remarks()->create(['remarks' => $this->remarks]);
        $voyage->master_info()->create(['master_info' => $this->master_info]);

        Audit::create([
            'user'          => Auth::user()->name,
            'event'          => 'created_weekly_schedule_report',
            'old_values'     => [],
            'new_values'     => [
                'report_type' => $voyage->report_type,
            ],
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
        ]);

        ModelsVessel::where('id', $voyage->vessel_id)->increment('has_reports');

        $this->clearDraft();
        $this->clearForm();

        $this->redirect(TableWeeklyScheduleReport::class);
    }

    public function addPort()
    {
        $this->ports[] = [
            'port' => '',
            'activity' => '',
            'eta_etb' => null,
            'etcd' => null,
            'cargo' => '',
            'cargo_qty' => '',
            'remarks' => '',
            'agents' => [
                ['name' => '', 'address' => '', 'pic_name' => '', 'telephone' => '', 'mobile' => '', 'email' => '']
            ]
        ];

        $this->saveDraftToDatabase();
    }

    public function removePort($index)
    {
        unset($this->ports[$index]);
        $this->ports = array_values($this->ports);
        $this->saveDraftToDatabase();
    }

    public function removeAgent($portIndex, $agentIndex)
    {
        unset($this->ports[$portIndex]['agents'][$agentIndex]);
        $this->ports[$portIndex]['agents'] = array_values($this->ports[$portIndex]['agents']);
        $this->saveDraftToDatabase();
    }

    public function addAgent($portIndex)
    {
        $this->ports[$portIndex]['agents'][] = ['name' => '', 'address' => '', 'pic_name' => '', 'telephone' => '', 'mobile' => '', 'email' => ''];
        $this->saveDraftToDatabase();
    }

    public function clearDraft()
    {
        Draft::where('user_id', Auth::id())
            ->where('type', 'weekly_schedule')
            ->delete();
    }

    public function clearForm()
    {
        $this->clearDraft();

        $this->reset([
            'voyage_no',
            'all_fast_datetime',
            'master_info',
            'remarks',
            'ports',
        ]);

        $this->addPort();
    }

    public function render()
    {
        return view('livewire.unit.weekly-schedule');
    }
}
