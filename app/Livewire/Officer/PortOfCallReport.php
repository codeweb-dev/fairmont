<?php

namespace App\Livewire\Officer;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use App\Models\Voyage;

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

    public function render()
    {
        $reports = Voyage::with(['vessel', 'unit', 'ports.agents', 'master_info'])
            ->where('report_type', 'Port Of Call')
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

        return view('livewire.officer.port-of-call-report', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
