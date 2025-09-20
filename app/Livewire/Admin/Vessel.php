<?php

namespace App\Livewire\Admin;

use App\Models\Audit;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use App\Models\Vessel as ModelsVessel;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;

#[Title('Vessel')]
class Vessel extends Component
{
    use WithPagination, WithoutUrlPagination;

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
        $query = ModelsVessel::query();

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return ceil($query->count() / $this->perPage);
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
        $vessel = ModelsVessel::findOrFail($id);

        if ($vessel->has_reports > 0) {
            Toaster::error('This vessel has associated reports. To preserve historical accuracy, deletion is not allowed. Please deactivate instead.');
            Flux::modal('delete-vessel-' . $id)->close();
            return;
        }

        $vessel->delete();
        Flux::modal('delete-vessel-' . $id)->close();
        Toaster::success('Vessel deleted successfully.');
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

    public function deactivate($id)
    {
        $vessel = ModelsVessel::findOrFail($id);

        $vessel->is_active = false;
        $vessel->save();

        $user = Auth::user();

        // Audit log - Deactive vessel
        Audit::create([
            'user' => $user->name,
            'event' => 'vessel_deactivated',
            'old_values' => ['is_active' => true],
            'new_values' => ['is_active' => false],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Flux::modal('deactivate-vessel-' . $id)->close();
        Toaster::success('Vessel deactivated successfully.');
    }

    public function activate($id)
    {
        $vessel = ModelsVessel::findOrFail($id);

        $vessel->is_active = true;
        $vessel->save();

        $user = Auth::user();

        // Audit log - Activate vessel
        Audit::create([
            'user' => $user->name,
            'event' => 'vessel_activated',
            'old_values' => ['is_active' => false],
            'new_values' => ['is_active' => true],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Flux::modal('deactivate-vessel-' . $id)->close();
        Toaster::success('Vessel activated successfully.');
    }

    public function render()
    {
        $query = ModelsVessel::query()->withCount('users');

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $_vessel = $query->orderBy('created_at', 'desc')
            ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

        $allowedRoles = ['unit', 'officer'];
        $users = User::role($allowedRoles)->get();

        return view('livewire.admin.vessel', [
            '_vessel' => $_vessel,
            'users'   => $users,
        ]);
    }
}
