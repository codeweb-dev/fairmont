<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use App\Models\Voyage;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

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
        $voyage->delete(); // This will soft delete it
        Toaster::success('Port Of Call Report soft deleted successfully.');
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

        return view('livewire.admin.port-of-call-report', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
