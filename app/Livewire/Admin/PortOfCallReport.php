<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use App\Models\Voyage;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Flux\Flux;

#[Title('Port Of Call Report')]
class PortOfCallReport extends Component
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
        Toaster::success('Port Of Call Report soft deleted successfully.');
        Flux::modal('delete-report-' . $id)->close();
    }

    public function render()
    {
        $reports = Voyage::with(['vessel', 'unit', 'ports.agents', 'master_info'])
            ->where('report_type', 'Port Of Call')
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
            ->paginate($this->perPage);

        return view('livewire.admin.port-of-call-report', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
