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

    <x-admin-components.table :headers="['Name', 'Role', '']">
        <thead class="border-b dark:border-white/10 border-black/10 hover:bg-white/5 bg-black/5 transition-all">
            <tr>
                <th class="px-3 py-3">Name</th>
                <th class="px-3 py-3">Role</th>
                <th class="px-3 py-3"></th>
            </tr>
        </thead>

        @foreach ($users as $user)
            <tr class="hover:bg-white/5 bg-black/5 transition-all" wire:key="user-row-{{ $user->id }}">
                <td class="px-3 py-4">{{ $user->name }}</td>
                <td class="px-3 py-4 space-x-1">
                    <flux:badge size="sm" icon="check-badge">
                        {{ $user->roles->first()?->name ? $user->roles->first()?->name : 'No role assigned' }}
                    </flux:badge>
                </td>
                <td class="px-3 py-4">
                    @unless (auth()->id() === $user->id)
                        <flux:modal.trigger name="edit-user-{{ $user->id }}" wire:click="setEdit({{ $user->id }})"
                            wire:key="modal-{{ $user->id }}">
                            <flux:button icon:trailing="plus" size="sm">Add role</flux:button>
                        </flux:modal.trigger>

                        <flux:modal name="edit-user-{{ $user->id }}" class="min-w-[24rem] md:w-[32rem]"
                            wire:key="edit-modal-{{ $user->id }}">
                            <form wire:submit.prevent="edit">
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">Edit User</flux:heading>
                                        <flux:text class="mt-2">Add role for <strong>{{ $user->name }}</strong>.
                                        </flux:text>
                                    </div>

                                    <flux:select wire:model.defer="editData.role" placeholder="Choose role..."
                                        label="Role">
                                        @foreach ($roles as $role)
                                            <flux:select.option value="{{ $role->name }}">{{ $role->name }}
                                            </flux:select.option>
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

    <div class="mt-6 flex items-center justify-between">
        <flux:text>
            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
        </flux:text>

        <div class="flex items-center gap-2">
            <flux:text>Page</flux:text>
            <div class="w-12 overflow-hidden">
                <input type="text" max="{{ $users->lastPage() }}" wire:model.lazy="currentPage"
                    class="form-input w-full border rounded-lg block disabled:shadow-none dark:shadow-none text-base sm:text-sm py-1 h-8 leading-[1.375rem] bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 text-center" />
            </div>
            <flux:text>of {{ $users->lastPage() }}</flux:text>
        </div>
    </div>
</div>
