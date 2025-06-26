<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use App\Models\Voyage;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Flux\Flux;

#[Title('Weekly Schedule Report')]
class WeeklyScheduleReport extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $voyage = Voyage::findOrFail($id);
        $voyage->delete();
        Toaster::success('Weekly Schedule Report soft deleted successfully.');
        Flux::modal('delete-report-' . $id)->close();
    }

    public function render()
    {
        $reports = Voyage::with(['vessel', 'unit', 'ports.agents', 'master_info'])
            ->where('report_type', 'Weekly Schedule')
            ->when(
                $this->search,
                fn($q) =>
                $q->whereHas(
                    'unit',
                    fn($u) =>
                    $u->where('name', 'like', '%' . $this->search . '%')
                )
            )
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.weekly-schedule-report', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
