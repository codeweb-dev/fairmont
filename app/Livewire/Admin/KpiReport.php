<?php

namespace App\Livewire\Admin;

use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Voyage;
use Flux\Flux;

#[Title('Kpi Report')]
class KpiReport extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];
    public $currentPage = 1;

    public function updatingPerPage()
    {
        $this->resetPage();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedCurrentPage($value)
    {
        if ($value < 1) {
            $this->currentPage = 1;
        } elseif ($value > $this->getMaxPage()) {
            $this->currentPage = $this->getMaxPage();
        }
    }

    private function getMaxPage()
    {
        $query = Voyage::query();
        if (!empty($this->search)) {
            $query->where(function ($query) {
                $query->whereHas('unit', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('vessel', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            });
        }
        return ceil($query->count() / $this->perPage);
    }

    public function delete($id)
    {
        $voyage = Voyage::findOrFail($id);
        $voyage->delete();
        Toaster::success('KPI Report soft deleted successfully.');
        Flux::modal('delete-report-' . $id)->close();
    }

    public function render()
    {
        $reports = Voyage::query()
            ->with([
                'vessel',
                'unit',
                'waste',
                'remarks',
                'master_info',
            ])
            ->where('report_type', 'KPI')
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->whereHas('unit', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })->orWhereHas('vessel', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->latest()
            ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

        return view('livewire.admin.kpi-report', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
