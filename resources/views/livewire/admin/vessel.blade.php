<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">
            Vessel
        </h1>

        <div class="flex items-center gap-3">
            <div class="max-w-64">
                <flux:input wire:model.live="search" placeholder="Search vessel..." icon="magnifying-glass" />
            </div>
            <div class="max-w-18">
                <flux:select wire:model.live="perPage" placeholder="Rows per page">
                    @foreach ($pages as $page)
                        <flux:select.option value="{{ $page }}">{{ $page }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <flux:modal.trigger name="add-vessel">
                <flux:button icon:trailing="plus">Add Vessel</flux:button>
            </flux:modal.trigger>

            <flux:modal name="add-vessel" class="md:w-96">
                <form wire:submit="save">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Add New Vessel</flux:heading>
                            <flux:text class="mt-2">Fill out the form below to create a new vessel listing in your
                                store.
                            </flux:text>
                        </div>

                        <flux:input label="Name" placeholder="Enter vessel name" clearable wire:model.blur="name"
                            required />

                        <div class="flex">
                            <flux:spacer />

                            <flux:button type="submit" variant="primary">Save Vessel</flux:button>
                        </div>
                    </div>
                </form>
            </flux:modal>
        </div>
    </div>

    <x-admin-components.table :headers="['Name', 'Date', '', '']">
        @foreach ($_vessel as $vessel)
            <tr class="hover:bg-white/5 bg-black/5 transition-all">
                <td class="px-3 py-4">{{ $vessel->name }}</td>
                <td class="px-3 py-4">{{ $vessel->created_at->format('M d, h:i A') }}</td>
                <td class="px-3 py-4">
                    <flux:modal.trigger name="assign-user-{{ $vessel->id }}">
                        <flux:button icon="plus" size="xs"
                            wire:click="openAssignUserModal({{ $vessel->id }})">
                            Assign Unit/Officer
                        </flux:button>
                    </flux:modal.trigger>
                </td>

                <td class="px-3 py-4">
                    <flux:dropdown>
                        <flux:button icon:trailing="ellipsis-horizontal" size="xs" variant="ghost" />

                        <flux:menu>
                            <flux:menu.radio.group>
                                <flux:modal.trigger name="view-vessel-{{ $vessel->id }}">
                                    <flux:menu.item icon="eye">
                                        View Assigned User
                                    </flux:menu.item>
                                </flux:modal.trigger>
                                <flux:modal.trigger name="edit-vessel-{{ $vessel->id }}"
                                    wire:click="setEdit({{ $vessel->id }})">
                                    <flux:menu.item icon="pencil-square">
                                        Edit
                                    </flux:menu.item>
                                </flux:modal.trigger>

                                <flux:modal.trigger name="delete-vessel-{{ $vessel->id }}">
                                    <flux:menu.item icon="trash" variant="danger">
                                        Delete
                                    </flux:menu.item>
                                </flux:modal.trigger>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>

                    <flux:modal name="assign-user-{{ $vessel->id }}">
                        <form wire:submit.prevent="assignUserToVessel({{ $vessel->id }})">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Assigned User</flux:heading>
                                    <flux:text class="mt-2">Assigned User to Vessel
                                        <strong>{{ $vessel->name }}</strong>.
                                    </flux:text>
                                </div>

                                <flux:select wire:model="selectedUserId" label="Select User">
                                    <flux:select.option value="" selected>
                                        Select User
                                    </flux:select.option>
                                    @foreach ($users as $user)
                                        <flux:select.option value="{{ $user->id }}">{{ $user->name }} -
                                            {{ $user->roles->first()?->name }}</flux:select.option>
                                    @endforeach
                                </flux:select>
                                <div class="flex justify-end">
                                    <flux:button type="submit" variant="primary">Assign</flux:button>
                                </div>
                            </div>
                        </form>
                    </flux:modal>

                    <flux:modal name="delete-vessel-{{ $vessel->id }}" class="min-w-[22rem]">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Soft Delete Vessel?</flux:heading>
                                <flux:text class="mt-2">
                                    Are you sure you want to delete <strong>{{ $vessel->name }}</strong>?,
                                    This vessel will not be permanently deleted — it will be moved to trash and
                                    can be restored later.
                                </flux:text>
                            </div>

                            <div class="flex gap-2">
                                <flux:spacer />
                                <flux:modal.close>
                                    <flux:button variant="ghost">Cancel</flux:button>
                                </flux:modal.close>
                                <flux:button type="button" variant="danger" wire:click="delete({{ $vessel->id }})">
                                    Move to Trash
                                </flux:button>
                            </div>
                        </div>
                    </flux:modal>

                    <flux:modal name="view-vessel-{{ $vessel->id }}" class="min-w-[24rem] md:w-[32rem]">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Assigned Users</flux:heading>
                                <flux:text class="mt-2">
                                    Users assigned to <strong>{{ $vessel->name }}</strong>:
                                </flux:text>
                            </div>

                            @if ($vessel->users->count())
                                <ul>
                                    @foreach ($vessel->users as $user)
                                        <li class="py-4">
                                            <span class="font-medium">{{ $user->name }}</span>
                                            <flux:badge size="sm" icon="check-badge">
                                                {{ $user->roles->pluck('name')->implode(', ') }}</flux:badge>
                                        </li>
                                        @if (!$loop->last)
                                            <flux:separator />
                                        @endif
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center italic">No users assigned to this vessel.</div>
                            @endif

                            <div class="flex justify-end">
                                <flux:modal.close>
                                    <flux:button variant="primary">Close</flux:button>
                                </flux:modal.close>
                            </div>
                        </div>
                    </flux:modal>

                    <flux:modal name="edit-vessel-{{ $vessel->id }}" class="min-w-[24rem] md:w-[32rem]">
                        <form wire:submit.prevent="edit">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Edit Vessel</flux:heading>
                                    <flux:text class="mt-2">Update the details for
                                        <strong>{{ $vessel->name }}</strong>.
                                    </flux:text>
                                </div>

                                <flux:input label="Name" placeholder="Enter new vessel name" clearable
                                    wire:model.defer="editData.name" required />

                                <div class="flex">
                                    <flux:spacer />
                                    <flux:button type="submit" variant="primary">Update Vessel</flux:button>
                                </div>
                            </div>
                        </form>
                    </flux:modal>
                </td>
            </tr>
        @endforeach
    </x-admin-components.table>

    <div class="mt-6">
        {{ $_vessel->links() }}
    </div>
</div>
