<?php

namespace App\Livewire\Unit;

use App\Models\Audit;
use App\Models\Notification;
use App\Models\Voyage;
use App\Models\Vessel as ModelsVessel;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;

class EditOnBoardReport extends Component
{
    public $voyageId;
    public $voyage;
    public $vessel_id;
    public $remarks;
    public $master_info;
    public $vesselName;

    public bool $onBoardMode = true;
    public array $board_crew = [];
    public array $crew_change = [];

    public function mount($id)
    {
        $this->voyageId = $id;
        $this->loadVoyageData();
    }

    private function loadVoyageData()
    {
        $this->voyage = Voyage::with([
            'vessel',
            'board_crew',
            'crew_change',
            'remarks',
            'master_info'
        ])->findOrFail($this->voyageId);

        // Check if user has permission to edit this voyage
        if ($this->voyage->unit_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this voyage.');
        }

        // Load vessel data
        $this->vessel_id = $this->voyage->vessel_id;
        $this->vesselName = $this->voyage->vessel->name;

        // Load existing data
        $this->loadCrewData();

        // Load remarks and master info
        if ($this->voyage->remarks) {
            $this->remarks = $this->voyage->remarks->remarks;
        }
        if ($this->voyage->master_info) {
            $this->master_info = $this->voyage->master_info->master_info;
        }

        // Determine which mode to start in based on existing data
        $this->determineInitialMode();
    }

    private function loadCrewData()
    {
        // Load board crew data
        $this->board_crew = [];
        foreach ($this->voyage->board_crew as $crew) {
            $this->board_crew[] = [
                'no' => $crew->no,
                'vessel_name' => $crew->vessel_name,
                'crew_surname' => $crew->crew_surname,
                'crew_first_name' => $crew->crew_first_name,
                'rank' => $crew->rank,
                'crew_nationality' => $crew->crew_nationality,
                'joining_date' => $crew->joining_date,
                'contract_completion' => $crew->contract_completion,
                'current_date' => $crew->current_date,
                'days_contract_completion' => $crew->days_contract_completion,
                'months_on_board' => $crew->months_on_board,
            ];
        }

        // Load crew change data
        $this->crew_change = [];
        foreach ($this->voyage->crew_change as $crew) {
            $this->crew_change[] = [
                'vessel_name' => $crew->vessel_name,
                'port' => $crew->port,
                'country' => $crew->country,
                'joiners_boarding' => $crew->joiners_boarding,
                'off_signers' => $crew->off_signers,
                'joiner_ranks' => $crew->joiner_ranks,
                'off_signers_ranks' => $crew->off_signers_ranks,
                'total_crew_change' => $crew->total_crew_change,
                'reason_change' => $crew->reason_change,
                'remarks' => $crew->remarks,
            ];
        }

        // Ensure at least one empty row exists for each type if none exist
        if (empty($this->board_crew)) {
            $this->addBoardRow();
        }
        if (empty($this->crew_change)) {
            $this->addCrewRow();
        }
    }

    private function determineInitialMode()
    {
        // Start with onBoard mode if there's board crew data, otherwise crew change mode
        if ($this->voyage->board_crew->count() > 0) {
            $this->onBoardMode = true;
        } elseif ($this->voyage->crew_change->count() > 0) {
            $this->onBoardMode = false;
        } else {
            // Default to onBoard mode if no data exists
            $this->onBoardMode = true;
        }
    }

    public function switchToOnBoard()
    {
        $this->onBoardMode = true;
    }

    public function switchToCrewChange()
    {
        $this->onBoardMode = false;
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
    }

    public function removeCrewRow($index)
    {
        if (count($this->crew_change) > 1) {
            unset($this->crew_change[$index]);
            $this->crew_change = array_values($this->crew_change);
        }
    }

    public function removeBoardRow($index)
    {
        if (count($this->board_crew) > 1) {
            unset($this->board_crew[$index]);
            $this->board_crew = array_values($this->board_crew);
        }
    }

    public function update()
    {
        $this->validate([
            'vessel_id' => 'required|exists:vessels,id',
            'master_info' => 'nullable|string|max:5000',
            'remarks' => 'nullable|string|max:5000',
        ]);

        $vessel = ModelsVessel::findOrFail($this->vessel_id);

        if (!$vessel->is_active) {
            Toaster::error('This vessel has been deactivated. It will no longer be available for report updates.');
            return;
        }

        // Store old values for audit
        $oldValues = $this->voyage->toArray();

        // Delete existing crew data to replace with updated data
        $this->voyage->board_crew()->delete();
        $this->voyage->crew_change()->delete();

        // Save board crew data (filter out empty rows)
        $validBoardCrew = collect($this->board_crew)->filter(function ($crew) {
            return !empty($crew['crew_surname']) || !empty($crew['crew_first_name']) ||
                !empty($crew['rank']) || !empty($crew['no']);
        });

        foreach ($validBoardCrew as $boardCrew) {
            $this->voyage->board_crew()->create([
                'no' => $boardCrew['no'],
                'vessel_name' => $boardCrew['vessel_name'] ?? $this->vesselName,
                'crew_surname' => $boardCrew['crew_surname'],
                'crew_first_name' => $boardCrew['crew_first_name'],
                'rank' => $boardCrew['rank'],
                'crew_nationality' => $boardCrew['crew_nationality'],
                'joining_date' => $boardCrew['joining_date'],
                'contract_completion' => $boardCrew['contract_completion'],
                'current_date' => $boardCrew['current_date'],
                'days_contract_completion' => $boardCrew['days_contract_completion'],
                'months_on_board' => $boardCrew['months_on_board'],
            ]);
        }

        // Save crew change data (filter out empty rows)
        $validCrewChange = collect($this->crew_change)->filter(function ($crew) {
            return !empty($crew['port']) || !empty($crew['country']) ||
                !empty($crew['joiner_ranks']) || !empty($crew['off_signers_ranks']);
        });

        foreach ($validCrewChange as $crewChange) {
            $this->voyage->crew_change()->create([
                'vessel_name' => $crewChange['vessel_name'] ?? $this->vesselName,
                'port' => $crewChange['port'],
                'country' => $crewChange['country'],
                'joiners_boarding' => $crewChange['joiners_boarding'],
                'off_signers' => $crewChange['off_signers'],
                'joiner_ranks' => $crewChange['joiner_ranks'],
                'off_signers_ranks' => $crewChange['off_signers_ranks'],
                'total_crew_change' => $crewChange['total_crew_change'],
                'reason_change' => $crewChange['reason_change'],
                'remarks' => $crewChange['remarks'],
            ]);
        }

        // Update remarks and master info
        $this->voyage->remarks()->updateOrCreate(
            ['voyage_id' => $this->voyage->id],
            ['remarks' => $this->remarks]
        );

        $this->voyage->master_info()->updateOrCreate(
            ['voyage_id' => $this->voyage->id],
            ['master_info' => $this->master_info]
        );

        // Create notification
        Notification::create([
            'vessel_id' => $this->voyage->vessel_id,
            'text' => "{$this->voyage->report_type} report has been updated.",
        ]);

        // Create audit log
        Audit::create([
            'user' => Auth::user()->name,
            'event' => 'updated_crew_monitoring_plan_report',
            'old_values' => $oldValues,
            'new_values' => $this->voyage->fresh()->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Toaster::success('Crew Monitoring Plan Updated Successfully.');

        return redirect()->route($this->onBoardMode
            ? 'table-crew-monitoring-plan-report-on-board-crew'
            : 'table-crew-monitoring-plan-report-crew-change');
    }

    public function render()
    {
        return view('livewire.unit.edit-on-board-report');
    }
}
