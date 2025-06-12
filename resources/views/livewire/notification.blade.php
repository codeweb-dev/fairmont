<div class="space-y-2">
    @forelse ($notifications as $i => $notification)
        <div>
            <flux:heading>{{ $notification->text }}</flux:heading>
            <flux:text class="mt-1">{{ $notification->created_at->diffForHumans() }}</flux:text>
        </div>
        @if ($i < $notifications->count() - 1)
            <flux:separator class="my-3" />
        @endif
    @empty
        <flux:text class="mt-2 text-center">No notifications.</flux:text>
    @endforelse

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</div>
