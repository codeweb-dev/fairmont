<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">
            Trashed {{ $viewing === 'users' ? 'Users' : 'Reports' }}
        </h1>

        <div class="flex items-center gap-3">
            <div class="flex gap-2">
                <flux:button :variant="$viewing === 'users' ? 'primary' : 'filled'"
                    wire:click="$set('viewing', 'users')">
                    Trashed Users
                </flux:button>
                <flux:button :variant="$viewing === 'reports' ? 'primary' : 'filled'"
                    wire:click="$set('viewing', 'reports')">
                    Trashed Reports
                </flux:button>
            </div>

            <div class="max-w-64">
                <flux:input wire:model.live="search" placeholder="Search trashed users..." icon="magnifying-glass" />
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

    @if ($viewing === 'users')
        <x-admin-components.table>
            <thead class="border-b dark:border-white/10 border-black/10 hover:bg-white/5 bg-black/5 transition-all">
                <tr>
                    <th class="px-3 py-3">Name</th>
                    <th class="px-3 py-3">Email</th>
                    <th class="px-3 py-3">Deleted Date</th>
                    <th class="px-3 py-3"></th>
                </tr>
            </thead>

            @foreach ($items as $user)
                <tr class="hover:bg-white/5 bg-black/5 transition-all" wire:key="trash-user-row-{{ $user->id }}">
                    <td class="px-3 py-4">{{ $user->name }}</td>
                    <td class="px-3 py-4">{{ $user->email }}</td>
                    <td class="px-3 py-4">{{ $user->deleted_at }}</td>

                    <td class="px-3 py-4">
                        @unless (auth()->id() === $user->id)
                            <flux:dropdown wire:key="trash-user-dropdown-{{ $user->id }}">
                                <flux:button icon:trailing="ellipsis-horizontal" size="xs" variant="ghost" />

                                <flux:menu>
                                    <flux:menu.radio.group>
                                        <flux:modal.trigger name="restore-user-{{ $user->id }}">
                                            <flux:menu.item icon="arrow-path">
                                                Restore
                                            </flux:menu.item>
                                        </flux:modal.trigger>

                                        <flux:modal.trigger name="force-delete-user-{{ $user->id }}">
                                            <flux:menu.item icon="trash" variant="danger">
                                                Delete Permanently
                                            </flux:menu.item>
                                        </flux:modal.trigger>
                                    </flux:menu.radio.group>
                                </flux:menu>
                            </flux:dropdown>

                            <flux:modal name="force-delete-user-{{ $user->id }}" class="min-w-[22rem]"
                                wire:key="force-delete-user-modal-{{ $user->id }}">
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">Delete User Permanently?</flux:heading>
                                        <flux:text class="mt-2">
                                            This will permanently delete <strong>{{ $user->name }}</strong> from your
                                            store.
                                            This action cannot be undone.
                                        </flux:text>
                                    </div>

                                    <div class="flex gap-2">
                                        <flux:spacer />
                                        <flux:modal.close>
                                            <flux:button variant="ghost">Cancel</flux:button>
                                        </flux:modal.close>
                                        <flux:button type="button" variant="danger"
                                            wire:click="forceDelete({{ $user->id }})">
                                            Delete Permanently
                                        </flux:button>
                                    </div>
                                </div>
                            </flux:modal>

                            <flux:modal name="restore-user-{{ $user->id }}" class="min-w-[22rem]"
                                wire:key="restore-user-modal-{{ $user->id }}">
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">Restore User?</flux:heading>
                                        <flux:text class="mt-2">
                                            You're about to restore <strong>{{ $user->name }}</strong>. This user will
                                            become
                                            active and visible in your store again.
                                        </flux:text>
                                    </div>

                                    <div class="flex gap-2">
                                        <flux:spacer />
                                        <flux:modal.close>
                                            <flux:button variant="ghost">Cancel</flux:button>
                                        </flux:modal.close>
                                        <flux:button type="button" variant="primary"
                                            wire:click="restore({{ $user->id }})">
                                            Confirm Restore
                                        </flux:button>
                                    </div>
                                </div>
                            </flux:modal>
                        @endunless
                    </td>
                </tr>
            @endforeach
        </x-admin-components.table>
    @else
        <x-admin-components.table>
            <thead class="border-b dark:border-white/10 border-black/10 hover:bg-white/5 bg-black/5 transition-all">
                <tr>
                    <th class="px-3 py-3">Report Type</th>
                    <th class="px-3 py-3">Vessel</th>
                    <th class="px-3 py-3">Vessel User</th>
                    <th class="px-3 py-3">Deleted Date</th>
                    <th class="px-3 py-3"></th>
                </tr>
            </thead>

            @foreach ($items as $report)
                <tr class="hover:bg-white/5 bg-black/5 transition-all" wire:key="trash-report-row-{{ $report->id }}">
                    <td class="px-3 py-4">{{ $report->report_type }}</td>
                    <td class="px-3 py-4">{{ $report->vessel->name ?? '' }}</td>
                    <td class="px-3 py-4">{{ $report->unit->name ?? '' }}</td>
                    <td class="px-3 py-4">{{ $report->deleted_at }}</td>
                    <td class="px-3 py-4">
                        <flux:dropdown wire:key="trash-report-dropdown-{{ $report->id }}">
                            <flux:button icon:trailing="ellipsis-horizontal" size="xs" variant="ghost" />
                            <flux:menu>
                                <flux:menu.radio.group>
                                    <flux:modal.trigger name="restore-report-{{ $report->id }}">
                                        <flux:menu.item icon="arrow-path">Restore</flux:menu.item>
                                    </flux:modal.trigger>
                                    <flux:modal.trigger name="force-delete-report-{{ $report->id }}">
                                        <flux:menu.item icon="trash" variant="danger">Delete Permanently
                                        </flux:menu.item>
                                    </flux:modal.trigger>
                                </flux:menu.radio.group>
                            </flux:menu>
                        </flux:dropdown>

                        <flux:modal name="restore-report-{{ $report->id }}" class="min-w-[22rem]"
                            wire:key="restore-report-modal-{{ $report->id }}">
                            <div class="space-y-6">
                                <flux:heading size="lg">Restore</flux:heading>
                                <flux:text class="mt-2">Restore {{ $report->report_type }}?</flux:text>
                                <div class="flex gap-2">
                                    <flux:spacer />
                                    <flux:modal.close>
                                        <flux:button variant="ghost">Cancel</flux:button>
                                    </flux:modal.close>
                                    <flux:button type="button" wire:click="restoreReport({{ $report->id }})">Confirm
                                        Restore</flux:button>
                                </div>
                            </div>
                        </flux:modal>

                        <flux:modal name="force-delete-report-{{ $report->id }}" class="min-w-[22rem]"
                            wire:key="force-delete-report-modal-{{ $report->id }}">
                            <div class="space-y-6">
                                <flux:heading size="lg">Permanently Delete?</flux:heading>
                                <flux:text class="mt-2">This will permanently delete the report and cannot be undone.
                                </flux:text>
                                <div class="flex gap-2">
                                    <flux:spacer />
                                    <flux:modal.close>
                                        <flux:button variant="ghost">Cancel</flux:button>
                                    </flux:modal.close>
                                    <flux:button type="button" variant="danger"
                                        wire:click="forceDeleteReport({{ $report->id }})">Delete</flux:button>
                                </div>
                            </div>
                        </flux:modal>
                    </td>
                </tr>
            @endforeach
        </x-admin-components.table>
    @endif

    <div class="mt-6 flex items-center justify-between">
        <flux:text>
            Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{ $items->total() }} results
        </flux:text>

        <div class="flex items-center gap-2">
            <flux:text>Page</flux:text>
            <div class="w-12 overflow-hidden">
                <input type="text" max="{{ $items->lastPage() }}" wire:model.lazy="currentPage"
                    class="form-input w-full border rounded-lg block disabled:shadow-none dark:shadow-none text-base sm:text-sm py-1 h-8 leading-[1.375rem] bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 text-center" />
            </div>
            <flux:text>of {{ $items->lastPage() }}</flux:text>
        </div>
    </div>
</div>
