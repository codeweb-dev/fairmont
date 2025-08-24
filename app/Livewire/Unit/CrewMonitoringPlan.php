<?php

namespace App\Livewire\Unit;

use App\Models\Audit;
use App\Models\Draft;
use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use App\Models\Voyage;

class CrewMonitoringPlan extends Component
{
    public $vessel_id;
    public $remarks;
    public $master_info;
    public $vesselName;

    public bool $onBoardMode = true;
    public array $board_crew = [];
    public array $crew_change = [];
    protected $listeners = ['saveDraft'];

    public function switchToOnBoard()
    {
        $this->onBoardMode = true;
        $this->saveDraftToDatabase();
    }

    public function switchToCrewChange()
    {
        $this->onBoardMode = false;
        $this->saveDraftToDatabase();
    }

    public function autoSave()
    {
        $this->saveDraftToDatabase();
    }

    private function saveDraftToDatabase()
    {
        Draft::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'type'    => 'crew_monitoring_plan',
            ],
            [
                'data' => json_encode($this->only([
                    'remarks',
                    'master_info',
                    'crew_change',
                    'board_crew',
                    'onBoardMode',
                ])),
            ]
        );
    }

    public function loadDraft()
    {
        $draft = Draft::where('user_id', Auth::id())
            ->where('type', 'crew_monitoring_plan')
            ->first();

        if ($draft) {
            $data = json_decode($draft->data, true);

            $this->onBoardMode  = $data['onBoardMode']  ?? true;
            $this->crew_change  = $data['crew_change']  ?? [];
            $this->board_crew   = $data['board_crew']   ?? [];
            $this->remarks      = $data['remarks']      ?? '';
            $this->master_info  = $data['master_info']  ?? '';
        }
    }

    public function clearDraft()
    {
        Draft::where('user_id', Auth::id())
            ->where('type', 'crew_monitoring_plan')
            ->delete();
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

        if (empty($this->crew_change)) {
            $this->addCrewRow();
        }

        if (empty($this->board_crew)) {
            $this->addBoardRow();
        }
    }

    public function addCrewRow()
    {
        $this->crew_change[] = [
            'vessel_name' => $this->vesselName,
            'port' => null,
            'country' => null,
            'joiners_boarding' => null,
            'off_signers' => null,
            'joiner_ranks' => null,
            'off_signers_ranks' => null,
            'total_crew_change' => null,
            'reason_change' => null,
            'remarks' => null,
        ];

        $this->saveDraftToDatabase();
    }

    public function addBoardRow()
    {
        $this->board_crew[] = [
            'no' => null,
            'vessel_name' => $this->vesselName,
            'crew_surname' => null,
            'crew_first_name' => null,
            'rank' => null,
            'crew_nationality' => null,
            'joining_date' => null,
            'contract_completion' => null,
            'current_date' => null,
            'days_contract_completion' => null,
            'months_on_board' => null,
        ];

        $this->saveDraftToDatabase();
    }

    public function removeCrewRow($index)
    {
        unset($this->crew_change[$index]);
        $this->crew_change = array_values($this->crew_change);
        $this->saveDraftToDatabase();
    }

    public function removeBoardRow($index)
    {
        unset($this->board_crew[$index]);
        $this->board_crew = array_values($this->board_crew);
        $this->saveDraftToDatabase();
    }

    public function save()
    {
        $this->validate([
            'vessel_id' => 'required|exists:vessels,id',
            'master_info' => 'nullable|string|max:5000',
            'remarks' => 'nullable|string|max:5000',
        ]);

        $voyage = Voyage::create([
            'vessel_id' => $this->vessel_id,
            'unit_id' => Auth::id(),
            'report_type' => 'Crew Monitoring Plan',
        ]);

        Notification::create([
            'vessel_id' => $voyage->vessel_id,
            'text'      => "{$voyage->report_type} report has been created.",
        ]);

        if ($this->onBoardMode) {
            foreach ($this->board_crew as $board_crew) {
                $voyage->board_crew()->create($board_crew);
            }
        } else {
            foreach ($this->crew_change as $crew_change) {
                $voyage->crew_change()->create($crew_change);
            }
        }

        $voyage->remarks()->create(['remarks' => $this->remarks]);
        $voyage->master_info()->create(['master_info' => $this->master_info]);

        Audit::create([
            'auditable_id'   => $voyage->id,
            'auditable_type' => Voyage::class,
            'user_id'        => Auth::id(),
            'event'          => 'created_crew_monitoring_plan_report',
            'old_values'     => [],
            'new_values'     => [
                'report_type' => $voyage->report_type,
            ],
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
        ]);

        Toaster::success('Crew Monitoring Plan Created Successfully');
        $this->clearDraft();
        $this->clearForm();

        $this->redirect(
            route(
                $this->onBoardMode
                    ? 'table-crew-monitoring-plan-report-on-board-crew'
                    : 'table-crew-monitoring-plan-report-crew-change'
            )
        );
    }

    public function clearForm()
    {
        $this->switchToOnBoard();
        $this->clearDraft();
        $this->reset([
            'master_info',
            'crew_change',
            'board_crew',
            'remarks',
            'master_info',
        ]);
        $this->addCrewRow();
        $this->addBoardRow();
    }

    public function goBack()
    {
        return redirect()->route($this->onBoardMode
            ? 'table-crew-monitoring-plan-report-on-board-crew'
            : 'table-crew-monitoring-plan-report-crew-change');
    }

    public function render()
    {
        return view('livewire.unit.crew-monitoring-plan');
    }
}
