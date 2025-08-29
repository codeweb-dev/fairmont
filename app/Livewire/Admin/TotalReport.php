<?php

namespace App\Livewire\Admin;

use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Voyage;
use Flux\Flux;

#[Title('Total Report')]
class TotalReport extends Component
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
        Toaster::success('Report soft deleted successfully.');
        Flux::modal('delete-report-' . $id)->close();
    }

    public function render()
    {
        $reports = Voyage::query()
            ->with(['vessel', 'unit', 'robs'])
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('voyage_no', 'like', '%' . $this->search . '%')
                        ->orWhere('report_type', 'like', '%' . $this->search . '%') // ✅ Search by report type
                        ->orWhereHas('unit', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('vessel', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.total-report', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
