<?php

namespace App\Livewire\Officer;

use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Voyage;
use Illuminate\Support\Facades\Auth;

#[Title('Total Report')]
class TotalReport extends Component
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
                $query->where('voyage_no', 'like', '%' . $this->search . '%')
                    ->orWhere('report_type', 'like', '%' . $this->search . '%')
                    ->orWhereHas('unit', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('vessel', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        return ceil($query->count() / $this->perPage);
    }

    public function render()
    {
        $user = Auth::user();

        $officerVessels = $user->vessels()
            ->pluck('vessels.name', 'vessels.id')
            ->toArray();

        $reports = Voyage::query()
            ->with(['vessel', 'unit', 'robs'])
            ->whereIn('vessel_id', array_keys($officerVessels))
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('voyage_no', 'like', '%' . $this->search . '%')
                        ->orWhere('report_type', 'like', '%' . $this->search . '%')
                        ->orWhereHas('unit', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('vessel', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->latest()
            ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

        return view('livewire.officer.total-report', [
            'reports'        => $reports,
            'pages'          => $this->pages,
            'officerVessels' => $officerVessels,
        ]);
    }
}
