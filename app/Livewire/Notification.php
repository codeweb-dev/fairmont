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

    public function render()
    {
        $user = Auth::user();
        $query = NotificationModel::query()->orderBy('created_at', 'desc');

        if ($user->hasRole('officer')) {
            $vesselId = $user->vessels()->first()?->id;

            if ($vesselId) {
                $query->where('vessel_id', $vesselId);
            } else {
                $query->whereRaw('1=0');
            }
        }

        return view('livewire.notification', [
            'notifications' => $query->simplePaginate(10),
            'notificationCount' => $query->count(),
        ]);
    }
}
