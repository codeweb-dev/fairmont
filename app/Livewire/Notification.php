<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notification as NotificationModel;
use Illuminate\Support\Facades\Auth;

class Notification extends Component
{
    public $notifications = [];

    public function mount()
    {
        $this->notifications = NotificationModel::orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.notification');
    }
}
