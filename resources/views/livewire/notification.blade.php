<span>
    <flux:modal.trigger name="notification">
        <flux:tooltip content="Notification" position="bottom">
            <span class="relative">
                <flux:button icon="bell" variant="subtle" />
                <span class="text-[8px] py-0.5 px-1 rounded-full bg-red-500 text-white absolute -top-2 right-1 pointer-events-none">
                    {{ $notificationCount }}
                </span>
            </span>
        </flux:tooltip>
    </flux:modal.trigger>

    <flux:modal name="notification" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Notification</flux:heading>
                <flux:text class="mt-2">
                    All notifications are shown below.
                </flux:text>
            </div>

            <flux:separator />

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
        </div>
    </flux:modal>
    </div>
