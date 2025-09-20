<?php

namespace App\Livewire\Admin;

use App\Models\Audit as AuditModel;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\WithoutUrlPagination;

#[Title('Audit Logs')]
class Audit extends Component
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
        $query = AuditModel::query();
        if (!empty($this->search)) {
            $query->where('event', 'like', '%' . $this->search . '%')
                ->orWhere('auditable_type', 'like', '%' . $this->search . '%');
        }
        return ceil($query->count() / $this->perPage);
    }

    public function render()
    {
        $query = AuditModel::query()->with('user')->latest();

        if (!empty($this->search)) {
            $query->where('event', 'like', '%' . $this->search . '%')
                ->orWhere('auditable_type', 'like', '%' . $this->search . '%');
        }

        $audits = $query->paginate($this->perPage, ['*'], 'page', $this->currentPage);

        return view('livewire.admin.audit', [
            'audits' => $audits,
            'pages' => $this->pages,
        ]);
    }
}
