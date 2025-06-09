<?php

namespace App\Livewire\Unit;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use App\Models\Voyage;

class CrewMonitoringPlan extends Component
{
    public $vessel_id;
    public $master_info;
    public $vesselName = null;

    public bool $onBoardMode = true;
    public array $board_crew = [];
    public array $crew_change = [];

    public function switchToOnBoard()
    {
        $this->onBoardMode = true;
    }

    public function switchToCrewChange()
    {
        $this->onBoardMode = false;
    }

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

        $this->addCrewRow();
        $this->addBoardRow();
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
        unset($this->crew_change[$index]);
        $this->crew_change = array_values($this->crew_change);
    }

    public function removeBoardRow($index)
    {
        unset($this->board_crew[$index]);
        $this->board_crew = array_values($this->board_crew);
    }

    public function save()
    {
        $this->validate([
            'vessel_id' => 'required|exists:vessels,id',
            'master_info' => 'nullable|string|max:5000',
        ]);

        $voyage = Voyage::create([
            'vessel_id' => $this->vessel_id,
            'unit_id' => Auth::id(),
            'report_type' => 'Crew Monitoring Plan',
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

        $voyage->master_info()->create(['master_info' => $this->master_info]);

        Toaster::success('Crew Monitoring Plan Created Successfully');
        $this->clearForm();
    }

    public function export()
    {
        Toaster::info('Export feature not implemented yet.');
    }

    public function clearForm()
    {
        $this->reset([
            'master_info',
            'crew_change',
            'board_crew',
        ]);
        $this->addCrewRow();
        $this->addBoardRow();
    }

    public function render()
    {
        return view('livewire.unit.crew-monitoring-plan');
    }
}
