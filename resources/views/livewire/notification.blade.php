<span>
    <flux:modal.trigger name="notification">
        <flux:tooltip content="Notification" position="bottom">
            <span class="relative">
                <flux:button icon="bell" variant="subtle" />
                <span
                    class="text-[8px] py-0.5 px-1 rounded-full bg-red-500 text-white absolute -top-2 right-1 pointer-events-none">
                    {{ $notificationCount }}
                </span>
            </span>
        </flux:tooltip>
    </flux:modal.trigger>

    <flux:modal name="notification" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Notifications</flux:heading>
                <flux:text class="mt-2">All notifications are shown below.</flux:text>
            </div>

            <flux:separator />

            <div class="space-y-2">
                @forelse ($notifications as $i => $notification)
                    <div class="flex justify-between items-center">
                        <div>
                            <flux:heading class="{{ $notification->is_read ? '' : 'text-blue-300' }}">
                                {{ $notification->text }}
                            </flux:heading>
                            <flux:text>
                                {{ $notification->created_at->diffForHumans() }}
                            </flux:text>
                        </div>

                        @if (!$notification->is_read)
                            <flux:button size="xs" icon="check-circle"
                                wire:click="markAsRead({{ $notification->id }})" />
                        @endif
                    </div>

                    @if ($i < $notifications->count() - 1)
                        <flux:separator class="my-2" />
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
