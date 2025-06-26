<?php

namespace App\Livewire\Admin;

use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Voyage;
use Flux\Flux;

#[Title('Noon Report')]
class NoonReport extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'tailwind';

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
        Toaster::success('Noon Report soft deleted successfully.');
        Flux::modal('delete-report-' . $id)->close();
    }

    public function render()
    {
        $reports = Voyage::query()
            ->with(['vessel', 'unit', 'rob_tanks', 'rob_fuel_reports', 'noon_report', 'remarks', 'master_info', 'weather_observations'])
            ->where('report_type', 'Noon Report')
            ->when($this->search, function ($query) {
                $query->whereHas(
                    'unit',
                    fn($q) =>
                    $q->where('name', 'like', '%' . $this->search . '%')
                );
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.noon-report', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
