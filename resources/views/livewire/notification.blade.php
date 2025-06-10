<div class="space-y-2">
    @forelse ($notifications as $notification)
        <div>
            <flux:heading>{{ $notification->text }}</flux:heading>
            <flux:text class="mt-1">{{ $notification->created_at->diffForHumans() }}</flux:text>
        </div>
    @empty
        <flux:text class="mt-2 text-center">No notifications.</flux:text>
    @endforelse
</div>
