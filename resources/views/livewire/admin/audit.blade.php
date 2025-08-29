<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">Audit Logs</h1>

        <div class="flex items-center gap-3">
            <div class="max-w-64">
                <flux:input wire:model.live="search" placeholder="Search events..." icon="magnifying-glass" />
            </div>

            <div class="max-w-18">
                <flux:select wire:model.live="perPage" placeholder="Rows per page">
                    @foreach ($pages as $page)
                        <flux:select.option value="{{ $page }}">{{ $page }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        </div>
    </div>

    <x-admin-components.table :headers="['User', 'Event', 'Date', '']">
        <thead class="border-b dark:border-white/10 border-black/10 hover:bg-white/5 bg-black/5 transition-all">
            <tr>
                <th class="px-3 py-3">User</th>
                <th class="px-3 py-3">Event</th>
                <th class="px-3 py-3">Date</th>
                <th class="px-3 py-3"></th>
            </tr>
        </thead>

        @foreach ($audits as $audit)
            <tr class="hover:bg-white/5 bg-black/5 transition-all">
                <td class="px-3 py-4">{{ $audit->user ?? 'N/A' }}</td>
                <td class="px-3 py-4">{{ $audit->event }}</td>
                <td class="px-3 py-4">{{ $audit->created_at->diffForHumans() }}</td>
                <td class="px-3 py-4">
                    <flux:modal.trigger name="view-audit-{{ $audit->id }}">
                        <flux:button icon="eye" size="sm">View</flux:button>
                    </flux:modal.trigger>

                    <flux:modal name="view-audit-{{ $audit->id }}" class="min-w-[24rem] md:w-[32rem]">
                        <div class="space-y-4">
                            <flux:heading size="lg">Audit Details</flux:heading>

                            <div class="space-y-2">
                                <flux:text class="font-bold">User:</flux:text>
                                <flux:text>{{ $audit->user ?? 'N/A' }}</flux:text>
                            </div>

                            <div class="space-y-2">
                                <flux:text class="font-bold">Event:</flux:text>
                                <flux:text>{{ $audit->event }}</flux:text>
                            </div>

                            <div class="space-y-2">
                                <flux:text class="font-bold">Date:</flux:text>
                                <flux:text>{{ $audit->created_at->toDayDateTimeString() }}</flux:text>
                            </div>

                            <div class="space-y-2">
                                <flux:text class="font-bold">Old Values:</flux:text>
                                <pre class="bg-black/10 p-2 rounded text-xs overflow-auto">{{ json_encode($audit->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                            </div>

                            <div class="space-y-2">
                                <flux:text class="font-bold">New Values:</flux:text>
                                <pre class="bg-black/10 p-2 rounded text-xs overflow-auto">{{ json_encode($audit->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                            </div>

                            <div class="space-y-2">
                                <flux:text class="font-bold">IP Address:</flux:text>
                                <flux:text>{{ $audit->ip_address }}</flux:text>
                            </div>

                            <div class="space-y-2">
                                <flux:text class="font-bold">User Agent:</flux:text>
                                <flux:text class="break-words">{{ $audit->user_agent }}</flux:text>
                            </div>
                        </div>
                    </flux:modal>
                </td>
            </tr>
        @endforeach
    </x-admin-components.table>

    <div class="mt-6">
        {{ $audits->links() }}
    </div>
</div>
