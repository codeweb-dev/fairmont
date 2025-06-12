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
        return view('livewire.notification', [
            'notifications' => NotificationModel::orderBy('created_at', 'desc')->simplePaginate(10),
        ]);
    }
}
