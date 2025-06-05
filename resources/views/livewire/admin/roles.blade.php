<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">
            Roles
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
        </div>
    </div>

    <x-admin-components.table :headers="['ID', 'Name', 'Role', '']">
        @foreach ($users as $user)
        <tr class="hover:bg-white/5 bg-black/5 transition-all">
            <td class="px-3 py-4">{{ $user->id }}</td>
            <td class="px-3 py-4">{{ $user->name }}</td>
            <td class="px-3 py-4 space-x-1">
                <flux:badge size="sm" icon="check-badge">{{ $user->roles->first()?->name ? $user->roles->first()?->name
                    : "No role assigned" }}</flux:badge>
            </td>
            <td class="px-3 py-4">
                @unless (auth()->id() === $user->id)
                <flux:modal.trigger name="edit-user-{{ $user->id }}" wire:click="setEdit({{ $user->id }})">
                    <flux:button icon:trailing="plus" size="sm">Add role</flux:button>
                </flux:modal.trigger>

                <flux:modal name="edit-user-{{ $user->id }}" class="min-w-[24rem] md:w-[32rem]">
                    <form wire:submit.prevent="edit">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Edit User</flux:heading>
                                <flux:text class="mt-2">Add role for <strong>{{ $user->name }}</strong>.
                                </flux:text>
                            </div>

                            <flux:select wire:model.defer="editData.role" placeholder="Choose role..." label="Role">
                                @foreach ($roles as $role)
                                <flux:select.option value="{{ $role->name }}">{{ $role->name }}</flux:select.option>
                                @endforeach
                            </flux:select>

                            <div class="flex">
                                <flux:spacer />
                                <flux:button type="submit" variant="primary">Update Role</flux:button>
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
