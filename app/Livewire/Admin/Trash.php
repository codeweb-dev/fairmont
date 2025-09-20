<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Voyage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Title;
use Flux\Flux;
use Masmerise\Toaster\Toaster;

#[Title('Trash')]
class Trash extends Component
{
    use WithPagination, WithoutUrlPagination;

    public string $viewing = 'users';
    public string $search = '';
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];
    public $currentPage = 1;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        $user->voyages()->onlyTrashed()->restore();

        Toaster::success('User and related reports restored successfully.');
        Flux::modal('restore-user-' . $id)->close();
    }

    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->voyages()->withTrashed()->forceDelete();
        $user->forceDelete();

        Toaster::success('User and related reports permanently deleted.');
        Flux::modal('force-delete-user-' . $id)->close();
    }

    public function restoreReport($id)
    {
        $voyage = Voyage::onlyTrashed()
            ->with(['vessel' => fn($q) => $q->withTrashed(), 'unit' => fn($q) => $q->withTrashed()])
            ->findOrFail($id);

        if ($voyage->unit && $voyage->unit->trashed()) {
            Toaster::error('Cannot restore report. Restore the user first.');
            Flux::modal('restore-report-' . $id)->close();
            return;
        }

        $voyage->restore();

        if ($voyage->vessel) {
            $voyage->vessel()->increment('has_reports');
        }

        Toaster::success('Report restored successfully.');
        Flux::modal('restore-report-' . $id)->close();
    }

    public function forceDeleteReport($id)
    {
        $voyage = Voyage::onlyTrashed()
            ->with(['vessel' => fn($q) => $q->withTrashed()])
            ->findOrFail($id);

        if ($voyage->vessel) {
            $voyage->vessel()->decrement('has_reports');
        }

        $voyage->forceDelete();
        Toaster::success('Report permanently deleted.');
        Flux::modal('force-delete-report-' . $id)->close();
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
        $query = $this->viewing === 'users'
            ? User::onlyTrashed()->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            : Voyage::onlyTrashed()
            ->with(['vessel', 'unit'])
            ->when($this->search, fn($q) => $q->where('voyage_no', 'like', "%{$this->search}%"));

        return ceil($query->count() / $this->perPage);
    }

    public function render()
    {
        $query = null;

        if ($this->viewing === 'users') {
            $query = User::onlyTrashed()
                ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"));
        } else {
            $query = Voyage::onlyTrashed()
                ->with(['vessel', 'unit'])
                ->when($this->search, fn($q) => $q->where('voyage_no', 'like', "%{$this->search}%"));
        }

        return view('livewire.admin.trash', [
            'items' => $query->paginate($this->perPage, ['*'], 'page', $this->currentPage),
            'pages' => $this->pages,
        ]);
    }
}
