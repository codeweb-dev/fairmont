<?php

namespace App\Livewire\Admin;

use App\Models\Audit as AuditModel;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\WithoutUrlPagination;

#[Title('Audit')]
class Audit extends Component
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

    public function render()
    {
        $query = AuditModel::query()->with('user')->latest();

        if (!empty($this->search)) {
            $query->where('event', 'like', '%' . $this->search . '%')
                ->orWhere('auditable_type', 'like', '%' . $this->search . '%');
        }

        $audits = $query->paginate($this->perPage);

        return view('livewire.admin.audit', [
            'audits' => $audits,
            'pages' => $this->pages,
        ]);
    }
}
