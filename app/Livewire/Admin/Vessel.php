<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use App\Models\Vessel as ModelsVessel;
use App\Models\User;
use Flux\Flux;

#[Title('Vessel')]
class Vessel extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'tailwind';

    public string $name = '';

    public $search = '';
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];
    public $editData = [
        'name' => '',
    ];
    public $editId = null;

    public $selectedVesselId = null;
    public $selectedUserId = null;

    // Always reset page on perPage/search update
    public function updatingPerPage()
    {
        $this->resetPage();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        ModelsVessel::create($validated);
        $this->reset();
        Flux::modal('add-vessel')->close();
        Toaster::success('Vessel created successfully.');
    }

    public function setEdit($id)
    {
        $vessel = ModelsVessel::findOrFail($id);
        $this->editId = $id;
        $this->editData = [
            'name' => $vessel->name,
        ];
    }

    public function edit()
    {
        $validated = $this->validate([
            'editData.name' => ['required', 'string', 'max:255'],
        ]);

        $vessel = ModelsVessel::findOrFail($this->editId);
        $vessel->name = $validated['editData']['name'];
        $vessel->save();

        Flux::modal('edit-vessel-' . $this->editId)->close();
        Toaster::success('Vessel updated successfully.');
        $this->reset(['editId', 'editData']);
    }

    public function delete($id)
    {
        ModelsVessel::findOrFail($id)->delete();
        Flux::modal('delete-vessel-' . $id)->close();
        Toaster::success('Vessel soft deleted successfully.');
    }

    public function openAssignUserModal($vesselId)
    {
        $this->selectedVesselId = $vesselId;
        $this->selectedUserId = null;
    }

    public function assignUserToVessel($vesselId = null)
    {
        $vesselId = $vesselId ?? $this->selectedVesselId;

        if (!$vesselId || !$this->selectedUserId) {
            Toaster::error('Please select both vessel and user.');
            return;
        }
        $vessel = ModelsVessel::find($vesselId);
        $user = User::find($this->selectedUserId);

        if (!$vessel || !$user) {
            Toaster::error('Vessel or User not found.');
            return;
        }

        if (!$vessel->users()->where('user_id', $user->id)->exists()) {
            $vessel->users()->attach($user->id);
            Toaster::success('User assigned successfully.');
        } else {
            Toaster::info('User is already assigned to this vessel.');
        }

        Flux::modal('assign-user-' . $vessel->id)->close();
        $this->selectedVesselId = null;
        $this->selectedUserId = null;
    }

    public function render()
    {
        $query = ModelsVessel::query();

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $_vessel = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        $allowedRoles = ['unit', 'officer'];
        $users = User::role($allowedRoles)->get();

        return view('livewire.admin.vessel', [
            '_vessel' => $_vessel,
            'users' => $users,
        ]);
    }
}
