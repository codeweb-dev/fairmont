<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable
        class="border-e w-72 border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                @if(auth()->user()->hasRole('admin'))
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>

                <flux:navlist.item icon="user" :href="route('users')" :current="request()->routeIs('users')"
                    wire:navigate>{{ __('User Management') }}</flux:navlist.item>

                <flux:navlist.item icon="check-badge" :href="route('roles')" :current="request()->routeIs('roles')"
                    wire:navigate>{{ __('Role Management') }}
                </flux:navlist.item>

                <flux:navlist.item icon="home" :href="route('vessel')" :current="request()->routeIs('vessel')"
                    wire:navigate>{{ __('Vessel Management') }}</flux:navlist.item>

                <flux:navlist.item icon="newspaper" :href="route('reports')" :current="request()->routeIs('reports')"
                    wire:navigate>{{ __('Report Management') }}
                </flux:navlist.item>

                <flux:navlist.item icon="document-magnifying-glass" :href="route('audit')"
                    :current="request()->routeIs('audit')" wire:navigate>{{ __('Audit Logs') }}</flux:navlist.item>

                <flux:navlist.item icon="trash" :href="route('trash')" :current="request()->routeIs('trash')"
                    wire:navigate>{{ __('Trash Reports & Users') }}</flux:navlist.item>

                @elseif (auth()->user()->hasRole('unit'))
                {{-- For unit --}}
                @else
                {{-- For officer --}}
                @endif
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <!-- Desktop User Menu -->
        <flux:dropdown position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon-trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header
        class="block! bg-white lg:bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700 py-4">
        <flux:navbar class="lg:hidden w-full">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:navbar>

        <div class="flex items-center justify-between w-full">
            <div class="w-72">
                <flux:input icon="magnifying-glass" placeholder="Search reports or pages" />
            </div>

            <div class="flex items-center gap-3">
                <div>
                    <flux:tooltip content="Notification" position="bottom">
                        <flux:button icon="bell" variant="subtle" />
                    </flux:tooltip>
                    <flux:tooltip content="Settings" position="bottom">
                        <flux:button href="{{ route('settings.profile') }}" wire:navigate icon="cog-6-tooth"
                            variant="subtle" />
                    </flux:tooltip>
                    <flux:tooltip content="Need Help?" position="bottom">
                        <flux:button icon="information-circle" variant="subtle" />
                    </flux:tooltip>
                </div>

                <flux:separator vertical class="my-2" />

                <div>
                    <flux:dropdown x-data align="end">
                        <flux:button variant="subtle" square class="group" aria-label="Preferred color scheme">
                            <flux:icon.sun x-show="$flux.appearance === 'light'" variant="mini"
                                class="text-zinc-500 dark:text-white" />
                            <flux:icon.moon x-show="$flux.appearance === 'dark'" variant="mini"
                                class="text-zinc-500 dark:text-white" />
                            <flux:icon.moon x-show="$flux.appearance === 'system' && $flux.dark" variant="mini" />
                            <flux:icon.sun x-show="$flux.appearance === 'system' && ! $flux.dark" variant="mini" />
                        </flux:button>

                        <flux:menu>
                            <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'">Light</flux:menu.item>
                            <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'">Dark</flux:menu.item>
                            <flux:menu.item icon="computer-desktop" x-on:click="$flux.appearance = 'system'">System
                            </flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </div>
            </div>
        </div>
    </flux:header>

    {{ $slot }}

    @fluxScripts
    <x-toaster-hub />
</body>

</html>
