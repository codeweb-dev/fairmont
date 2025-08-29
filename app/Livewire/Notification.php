<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notification as NotificationModel;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Notification extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function markAsRead($id)
    {
        $notification = NotificationModel::find($id);

        if ($notification && !$notification->is_read) {
            $notification->update(['is_read' => true]);
        }
    }

    public function render()
    {
        $user = Auth::user();
        $query = NotificationModel::query()->orderBy('created_at', 'desc');

        if ($user->hasRole(['officer', 'unit'])) {
            $vesselIds = $user->vessels()->pluck('vessels.id');

            if ($vesselIds->isNotEmpty()) {
                $query->whereIn('vessel_id', $vesselIds);
            } else {
                $query->whereRaw('1=0');
            }
        }

        return view('livewire.notification', [
            'notifications' => $query->simplePaginate(10),
            'notificationCount' => (clone $query)->where('is_read', false)->count(),
        ]);
    }
}
