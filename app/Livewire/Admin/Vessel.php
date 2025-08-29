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

    public $reassignUserId = null;
    public $reassignToVesselId = null;

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

        $userRole = $user->roles->first()?->name;

        if ($userRole === 'unit') {
            // Check if this unit is already assigned to a vessel
            $currentVessel = $user->vessels()->first();

            if ($currentVessel && $currentVessel->id !== $vessel->id) {
                Toaster::error("This unit is already assigned to another vessel: {$currentVessel->name}.");
                return;
            }

            // If already assigned to this vessel, inform user
            if ($currentVessel && $currentVessel->id === $vessel->id) {
                Toaster::info('Unit is already assigned to this vessel.');
                return;
            }
        }

        // Attach only if not already attached
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

    public function reassignUserToVessel()
    {
        if (!$this->reassignUserId || !$this->reassignToVesselId) {
            Toaster::error('Please select both user and vessel.');
            return;
        }

        $user = User::find($this->reassignUserId);
        $newVessel = ModelsVessel::find($this->reassignToVesselId);

        if (!$user || !$newVessel) {
            Toaster::error('User or Vessel not found.');
            return;
        }

        // Detach user from all current vessels
        $user->vessels()->detach();

        // Attach to new vessel
        $newVessel->users()->attach($user->id);

        Toaster::success("{$user->name} has been reassigned to {$newVessel->name}.");

        Flux::modal('reassign-user')->close();
        $this->reset(['reassignUserId', 'reassignToVesselId']);
    }

    public function render()
    {
        $query = ModelsVessel::query()->withCount('users');

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $_vessel = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        $allowedRoles = ['unit', 'officer'];
        $users = User::role($allowedRoles)->get();

        return view('livewire.admin.vessel', [
            '_vessel' => $_vessel,
            'users'   => $users,
        ]);
    }
}
