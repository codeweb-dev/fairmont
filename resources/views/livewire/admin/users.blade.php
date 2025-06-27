<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">
            Users
        </h1>

        <div class="flex items-center gap-3">
            <div class="max-w-64">
                <flux:input wire:model.live="search" placeholder="Search users..." icon="magnifying-glass" />
            </div>
            <div class="max-w-18">
                <flux:select wire:model.live="perPage" placeholder="Rows per page">
                    @foreach ($pages as $page)
                        <flux:select.option value="{{ $page }}">{{ $page }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <flux:modal.trigger name="add-user">
                <flux:button icon:trailing="plus">Add User</flux:button>
            </flux:modal.trigger>

            <flux:modal name="add-user" class="md:w-96">
                <form wire:submit="save">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Add New User</flux:heading>
                            <flux:text class="mt-2">Fill out the form below to create a new user listing in your
                                store.
                            </flux:text>
                        </div>

                        <flux:input label="Name" placeholder="Enter user name" clearable wire:model.blur="name"
                            required />

                        <flux:input label="Email" placeholder="Enter user email" clearable wire:model.blur="email"
                            required />

                        <flux:input label="Password" type="password" placeholder="Enter user password" viewable
                            wire:model.blur="password" required />

                        <div class="flex">
                            <flux:spacer />

                            <flux:button type="submit" variant="primary">Save User</flux:button>
                        </div>
                    </div>
                </form>
            </flux:modal>
        </div>
    </div>

    <x-admin-components.table>
        <thead class="border-b dark:border-white/10 border-black/10 hover:bg-white/5 bg-black/5 transition-all">
            <tr>
                <th class="px-3 py-3">Name</th>
                <th class="px-3 py-3">Email</th>
                <th class="px-3 py-3">Role</th>
                <th class="px-3 py-3">Status</th>
                <th class="px-3 py-3">Date</th>
                <th class="px-3 py-3"></th>
            </tr>
        </thead>

        @foreach ($users as $user)
            <tr class="hover:bg-white/5 bg-black/5 transition-all">
                <td class="px-3 py-4">{{ $user->name }}</td>
                <td class="px-3 py-4">{{ $user->email }}</td>
                <td class="px-3 py-4 space-x-1">
                    <flux:badge size="sm" icon="check-badge">
                        {{ $user->roles->first()?->name ? $user->roles->first()?->name : 'No role assigned' }}
                    </flux:badge>
                </td>
                <td class="px-3 py-4">
                    <flux:badge size="sm" icon="{{ $user->is_active ? 'check' : 'x-mark' }}"
                        color="{{ $user->is_active ? 'green' : 'red' }}">
                        {{ $user->is_active ? 'Active' : 'Deactivate' }}</flux:badge>
                </td>
                <td class="px-3 py-4">{{ $user->created_at->format('M d, h:i A') }}</td>
                <td class="px-3 py-4">
                    @unless (auth()->id() === $user->id)
                        <flux:dropdown>
                            <flux:button icon:trailing="ellipsis-horizontal" size="xs" variant="ghost" />

                            <flux:menu>
                                <flux:menu.radio.group>
                                    <flux:modal.trigger name="view-user-{{ $user->id }}">
                                        <flux:menu.item icon="eye">
                                            View
                                        </flux:menu.item>
                                    </flux:modal.trigger>

                                    <flux:modal.trigger name="edit-user-{{ $user->id }}"
                                        wire:click="setEdit({{ $user->id }})">
                                        <flux:menu.item icon="pencil-square">
                                            Edit
                                        </flux:menu.item>
                                    </flux:modal.trigger>

                                    @if ($user->is_active)
                                        <flux:modal.trigger name="deactivate-user-{{ $user->id }}">
                                            <flux:menu.item icon="x-mark" variant="danger">
                                                Deactivate
                                            </flux:menu.item>
                                        </flux:modal.trigger>
                                    @else
                                        <flux:modal.trigger name="deactivate-user-{{ $user->id }}">
                                            <flux:menu.item icon="check">
                                                Activate
                                            </flux:menu.item>
                                        </flux:modal.trigger>
                                    @endif

                                    <flux:modal.trigger name="delete-user-{{ $user->id }}">
                                        <flux:menu.item icon="trash" variant="danger">
                                            Delete
                                        </flux:menu.item>
                                    </flux:modal.trigger>
                                </flux:menu.radio.group>
                            </flux:menu>
                        </flux:dropdown>

                        <flux:modal name="deactivate-user-{{ $user->id }}" class="min-w-[22rem]">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">
                                        {{ $user->is_active ? 'Deactivate User?' : 'Activate User?' }}
                                    </flux:heading>
                                    <flux:text class="mt-2">
                                        Are you sure you want to
                                        <strong>{{ $user->is_active ? 'deactivate' : 'activate' }}</strong>
                                        the user <strong>{{ $user->name }}</strong>?
                                    </flux:text>
                                </div>

                                <div class="flex gap-2">
                                    <flux:spacer />
                                    <flux:modal.close>
                                        <flux:button variant="ghost">Cancel</flux:button>
                                    </flux:modal.close>

                                    @if ($user->is_active)
                                        <flux:button type="button" variant="danger"
                                            wire:click="deactivate({{ $user->id }})">
                                            Deactivate
                                        </flux:button>
                                    @else
                                        <flux:button type="button" wire:click="activate({{ $user->id }})">
                                            Activate
                                        </flux:button>
                                    @endif
                                </div>
                            </div>
                        </flux:modal>

                        <flux:modal name="delete-user-{{ $user->id }}" class="min-w-[22rem]">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Soft Delete User?</flux:heading>
                                    <flux:text class="mt-2">
                                        Are you sure you want to delete <strong>{{ $user->name }}</strong>?,
                                        This user will not be permanently deleted — it will be moved to trash and
                                        can be restored later.
                                    </flux:text>
                                </div>

                                <div class="flex gap-2">
                                    <flux:spacer />
                                    <flux:modal.close>
                                        <flux:button variant="ghost">Cancel</flux:button>
                                    </flux:modal.close>
                                    <flux:button type="button" variant="danger" wire:click="delete({{ $user->id }})">
                                        Move to Trash
                                    </flux:button>
                                </div>
                            </div>
                        </flux:modal>

                        <flux:modal name="view-user-{{ $user->id }}" class="min-w-[24rem] md:w-[32rem]">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">User Details</flux:heading>
                                    <flux:text class="mt-2">Here are the details for
                                        <strong>{{ $user->name }}</strong>.
                                    </flux:text>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <flux:label>Username</flux:label>
                                        <p class="text-sm font-medium">{{ $user->name }}</p>
                                    </div>

                                    <div>
                                        <flux:label>Email</flux:label>
                                        <p class="text-sm font-medium">{{ $user->email }}</p>
                                    </div>

                                    <div>
                                        <flux:label>Role</flux:label>
                                        <flux:badge size="sm" icon="check-badge">{{ $user->roles->first()?->name }}
                                        </flux:badge>
                                    </div>

                                    <div>
                                        <flux:label>Created At</flux:label>
                                        <p class="text-sm text-gray-400">{{ $user->created_at->format('M d, Y h:i A') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <flux:modal.close>
                                        <flux:button variant="primary">Close</flux:button>
                                    </flux:modal.close>
                                </div>
                            </div>
                        </flux:modal>

                        <flux:modal name="edit-user-{{ $user->id }}" class="min-w-[24rem] md:w-[32rem]">
                            <form wire:submit.prevent="edit">
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">Edit User</flux:heading>
                                        <flux:text class="mt-2">Update the details for
                                            <strong>{{ $user->name }}</strong>.
                                        </flux:text>
                                    </div>

                                    <flux:input label="Name" placeholder="Enter new user name" clearable
                                        wire:model.defer="editData.name" required />

                                    <flux:input label="Email" placeholder="Enter new user email"
                                        wire:model.defer="editData.email" clearable required />

                                    <flux:input type="password" label="Password (Optional)"
                                        placeholder="Enter new user password" wire:model.defer="editData.password"
                                        viewable />

                                    {{-- <flux:select wire:model.defer="editData.role" placeholder="Choose role..."
                                label="Role">
                                @foreach ($roles as $role)
                                <flux:select.option value="{{ $role->name }}">{{ $role->name }}</flux:select.option>
                                @endforeach
                            </flux:select> --}}

                                    <div class="flex">
                                        <flux:spacer />
                                        <flux:button type="submit" variant="primary">Update User</flux:button>
                                    </div>
                                </div>
                            </form>
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
