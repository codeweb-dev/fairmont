<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">Trashed Users</h1>

        <div class="flex items-center gap-3">
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

    <x-admin-components.table :headers="['ID', 'Name', 'Email', 'Deleted At', '']">
        @foreach ($users as $user)
            <tr class="hover:bg-white/5 bg-black/5 transition-all">
                <td class="px-3 py-4">{{ $user->id }}</td>
                <td class="px-3 py-4">{{ $user->name }}</td>
                <td class="px-3 py-4">{{ $user->email }}</td>
                <td class="px-3 py-4">{{ $user->deleted_at }}</td>

                <td class="px-3 py-4">
                    @unless (auth()->id() === $user->id)
                        <flux:dropdown>
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

                        <flux:modal name="force-delete-user-{{ $user->id }}" class="min-w-[22rem]">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Delete User Permanently?</flux:heading>
                                    <flux:text class="mt-2">
                                        This will permanently delete <strong>{{ $user->name }}</strong> from your store.
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

                        <flux:modal name="restore-user-{{ $user->id }}" class="min-w-[22rem]">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Restore User?</flux:heading>
                                    <flux:text class="mt-2">
                                        You're about to restore <strong>{{ $user->name }}</strong>. This user will become
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

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
