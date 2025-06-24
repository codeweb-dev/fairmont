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

                <flux:navlist.item icon="document-magnifying-glass" :href="route('audit')"
                    :current="request()->routeIs('audit')" wire:navigate>{{ __('Audit Logs') }}</flux:navlist.item>

                <flux:navlist.item icon="trash" :href="route('trash')" :current="request()->routeIs('trash')"
                    wire:navigate>{{ __('Trash Reports & Users') }}</flux:navlist.item>

                <flux:navlist.group expandable heading="Report Management">
                    <flux:navlist.item href="{{ route('admin-noon-report') }}" :current="request()->routeIs('admin-noon-report')" wire:navigate>Noon Report</flux:navlist.item>

                    <flux:navlist.item href="{{ route('admin-departure-report') }}" :current="request()->routeIs('admin-departure-report')" wire:navigate>Departure Report</flux:navlist.item>

                    <flux:navlist.item href="{{ route('admin-arrival-report') }}" :current="request()->routeIs('admin-arrival-report')" wire:navigate>Arrival Report</flux:navlist.item>

                    <flux:navlist.item href="{{ route('admin-bunkering-report') }}" :current="request()->routeIs('admin-bunkering-report')" wire:navigate>Bunkering Report</flux:navlist.item>

                    <flux:navlist.item href="{{ route('admin-all-fast-report') }}" :current="request()->routeIs('admin-all-fast-report')" wire:navigate>All Fast Report</flux:navlist.item>

                    <flux:navlist.item href="{{ route('admin-weekly-schedule-report') }}" :current="request()->routeIs('admin-weekly-schedule-report')" wire:navigate>Weekly Schedule</flux:navlist.item>

                    <flux:navlist.item href="{{ route('admin-crew-monitoring-plan-report') }}" :current="request()->routeIs('admin-crew-monitoring-plan-report')" wire:navigate>Crew Monitoring Plan</flux:navlist.item>

                    <flux:navlist.item href="{{ route('admin-voyage-report') }}" :current="request()->routeIs('admin-voyage-report')" wire:navigate>Voyage Report</flux:navlist.item>

                    <flux:navlist.item href="{{ route('admin-kpi-report') }}" :current="request()->routeIs('admin-kpi-report')" wire:navigate>KPI Report</flux:navlist.item>

                    <flux:navlist.item href="{{ route('admin-port-of-call-report') }}" :current="request()->routeIs('admin-port-of-call-report')" wire:navigate>Port of Call</flux:navlist.item>
                </flux:navlist.group>

                @elseif (auth()->user()->hasRole('unit'))

                <flux:navlist.item icon="newspaper" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}
                </flux:navlist.item>

                <flux:navlist.item icon="newspaper" :href="route('table-noon-report')" :current="request()->routeIs('table-noon-report', 'noon-report')" wire:navigate>{{ __('Noon Report') }}
                </flux:navlist.item>

                <flux:navlist.item icon="newspaper" :href="route('table-departure-report')" :current="request()->routeIs('table-departure-report', 'departure-report')"
                    wire:navigate>{{ __('Departure Report') }}
                </flux:navlist.item>

                <flux:navlist.item icon="newspaper" :href="route('table-arrival-report')" :current="request()->routeIs('table-arrival-report', 'arrival-report')"
                    wire:navigate>{{ __('Arrival Report') }}
                </flux:navlist.item>

                <flux:navlist.item icon="newspaper" :href="route('table-bunkering-report')" :current="request()->routeIs('table-bunkering-report', 'bunkering')"
                    wire:navigate>{{ __('Bunkering') }}
                </flux:navlist.item>

                <flux:navlist.item icon="newspaper" :href="route('table-all-fast-report')" :current="request()->routeIs('table-all-fast-report', 'all-fast')"
                    wire:navigate>{{ __('All Fast') }}
                </flux:navlist.item>

                <flux:navlist.item icon="newspaper" :href="route('table-weekly-schedule-report')" :current="request()->routeIs('table-weekly-schedule-report', 'weekly-schedule')"
                    wire:navigate>{{ __('Weekly Schedule') }}
                </flux:navlist.item>

                <flux:navlist.item icon="newspaper" :href="route('table-crew-monitoring-plan-report')" :current="request()->routeIs('table-crew-monitoring-plan-report', 'crew-monitoring-plan')"
                    wire:navigate>{{ __('Crew Monitoring Plan') }}
                </flux:navlist.item>

                <flux:navlist.item icon="newspaper" :href="route('table-voyage-report')" :current="request()->routeIs('table-voyage-report', 'voyage-report')"
                    wire:navigate>{{ __('Voyage Report') }}
                </flux:navlist.item>

                <flux:navlist.item icon="newspaper" :href="route('table-kpi-report')" :current="request()->routeIs('table-kpi-report', 'kpi')"
                    wire:navigate>{{ __('KPI') }}
                </flux:navlist.item>

                <flux:navlist.item icon="newspaper" :href="route('table-port-of-call-report')" :current="request()->routeIs('table-port-of-call-report', 'port-of-call')"
                    wire:navigate>{{ __('Port Of Call') }}
                </flux:navlist.item>

                @elseif (auth()->user()->hasRole('officer'))
                <flux:navlist.item icon="newspaper" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}
                </flux:navlist.item>

                <flux:navlist.group expandable heading="Report Management">
                    <flux:navlist.item href="{{ route('officer-noon-report') }}" :current="request()->routeIs('officer-noon-report')" wire:navigate>Noon Report</flux:navlist.item>

                    <flux:navlist.item href="{{ route('officer-departure-report') }}" :current="request()->routeIs('officer-departure-report')" wire:navigate>Departure Report</flux:navlist.item>

                    <flux:navlist.item href="{{ route('officer-arrival-report') }}" :current="request()->routeIs('officer-arrival-report')" wire:navigate>Arrival Report</flux:navlist.item>

                    <flux:navlist.item href="{{ route('officer-bunkering-report') }}" :current="request()->routeIs('officer-bunkering-report')" wire:navigate>Bunkering</flux:navlist.item>

                    <flux:navlist.item href="{{ route('officer-all-fast-report') }}" :current="request()->routeIs('officer-all-fast-report')" wire:navigate>All Fast</flux:navlist.item>

                    <flux:navlist.item href="{{ route('officer-weekly-schedule-report') }}" :current="request()->routeIs('officer-weekly-schedule-report')" wire:navigate>Weekly Schedule</flux:navlist.item>

                    <flux:navlist.item href="{{ route('officer-crew-monitoring-plan-report') }}" :current="request()->routeIs('officer-crew-monitoring-plan-report')" wire:navigate>Crew Monitoring Plan</flux:navlist.item>

                    <flux:navlist.item href="{{ route('officer-voyage-report') }}" :current="request()->routeIs('officer-voyage-report')" wire:navigate>Voyage Report</flux:navlist.item>

                    <flux:navlist.item href="{{ route('officer-kpi-report') }}" :current="request()->routeIs('officer-kpi-report')" wire:navigate>KPI Report</flux:navlist.item>

                    <flux:navlist.item href="{{ route('officer-port-of-call-report') }}" :current="request()->routeIs('officer-port-of-call-report')" wire:navigate>Port of Call</flux:navlist.item>
                </flux:navlist.group>
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

        <div class="flex items-center justify-end w-full">
            <div class="flex items-center gap-3">
                <div>
                    <flux:modal.trigger name="global-search">
                        <flux:tooltip content="Search" position="bottom">
                            <flux:button icon="magnifying-glass" variant="subtle" />
                        </flux:tooltip>
                    </flux:modal.trigger>

                    <flux:modal name="global-search" class="md:w-[32rem]">
                        <div class="space-y-4">
                            <flux:heading size="lg">Search</flux:heading>

                            <livewire:global-search />
                        </div>
                    </flux:modal>

                    <flux:modal.trigger name="notification">
                        <flux:tooltip content="Notification" position="bottom">
                            <flux:button icon="bell" variant="subtle" />
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

                            <livewire:notification />
                        </div>
                    </flux:modal>
                    <flux:tooltip content="Settings" position="bottom">
                        <flux:button href="{{ route('settings.profile') }}" wire:navigate icon="cog-6-tooth"
                            variant="subtle" />
                    </flux:tooltip>

                    <flux:modal.trigger name="need-help">
                        <flux:tooltip content="Need Help?" position="bottom">
                            <flux:button icon="information-circle" variant="subtle" />
                        </flux:tooltip>
                    </flux:modal.trigger>

                    <flux:modal name="need-help" class="!max-w-6xl p-6 overflow-auto rounded-2xl shadow-xl bg-white">
                        <div class="flex flex-col gap-4 max-w-6xl">
                            <div>
                                <flux:heading size="lg">Need Help?</flux:heading>
                                <flux:text class="mt-2">Find quick answers and guides for the Fairmont Ship Reporting Tool.</flux:text>
                            </div>
                            <div x-data="{ open: null }" class="space-y-2">
                                <template x-for="(item, idx) in [
                                            {
                                                title: 'About Fairmont Ship Reporting Tool',
                                                content: `Fairmont Ship Reporting Tool is a secure web application designed to simplify the creation, management, and tracking of voyage reports for vessels.<br>
                                            It is intended for use by both vessel crew and office staff to ensure accurate and timely reporting.`
                                            },
                                            {
                                                title: 'Navigation Guide',
                                                content: `<ul class='list-disc pl-6 space-y-1 text-sm text-primary-600'>
                                                <li><strong>Dashboard:</strong> Overview of reports and quick access features</li>
                                                <li><strong>Create Report:</strong> Start a new report</li>
                                                <li><strong>Manage Reports:</strong> View, edit, and manage reports</li>
                                                <li><strong>Settings:</strong> Configure user settings, profile, password, and appearance</li>
                                                </ul>`
                                            },
                                            {
                                                title: 'Creating Reports',
                                                content: `<ol class='list-decimal pl-6 space-y-1 text-sm text-primary-600'>
                                                <li>Navigate to Create Report</li>
                                                <li>Select the type of report you want to create:
                                                    <ul class='list-disc pl-6'>
                                                    <li>Noon Report</li>
                                                    <li>Departure Report</li>
                                                    <li>Arrival Report</li>
                                                    <li>Bunkering Report</li>
                                                    <li>All Fast Report</li>
                                                    <li>Weekly Schedule</li>
                                                    <li>Crew Monitoring Plan</li>
                                                    <li>Voyage Report</li>
                                                    <li>KPI Report</li>
                                                    <li>Port of Call Report</li>
                                                    </ul>
                                                </li>
                                                <li>Fill out the required fields</li>
                                                <li>Review and submit your report</li>
                                                </ol>
                                                <p class='mt-2 text-sm text-primary-600'><span class='font-semibold'>Tip:</span> Required fields are marked clearly; please double-check all entries before submitting.</p>`
                                            },
                                            {
                                                title: 'Managing Reports',
                                                content: `<ul class='list-disc pl-6 space-y-1 text-sm text-primary-600'>
                                                <li>Use Manage Reports to:</li>
                                                <ul class='list-disc pl-6'>
                                                    <li>View all submitted reports</li>
                                                    <li>Edit reports (based on permissions and report type)</li>
                                                    <li>Delete or archive reports (Admin/Office User only)</li>
                                                    <li>Search reports by type, date, reportee, or vessel</li>
                                                </ul>
                                                </ul>`
                                            },
                                            {
                                                title: 'Exporting Reports',
                                                content: `<ul class='list-disc pl-6 space-y-1 text-sm text-primary-600'>
                                                <li>You can export reports to:
                                                    <ul class='list-disc pl-6'>
                                                    <li>Excel (XLSX) for editing or record-keeping</li>
                                                    <li>PDF (if implemented) for official submission</li>
                                                    </ul>
                                                </li>
                                                <li>Exports include:
                                                    <ul class='list-disc pl-6'>
                                                    <li>All visible fields and tables</li>
                                                    <li>Properly formatted layout for printing or sharing</li>
                                                    </ul>
                                                </li>
                                                </ul>`
                                            },
                                            {
                                                title: 'Security & Account Tips',
                                                content: `<ul class='list-disc pl-6 space-y-1 text-sm text-primary-600'>
                                                <li>Your session will auto-logout after 30 minutes of inactivity to protect your data.</li>
                                                <li>Make sure to choose a strong password with:
                                                    <ul class='list-disc pl-6'>
                                                    <li>Minimum length</li>
                                                    <li>Uppercase letters</li>
                                                    <li>Symbols</li>
                                                    </ul>
                                                </li>
                                                <li>If you forget your password, use Forgot Password on the login page to reset it.</li>
                                                <li>Admins can review login and activity logs for security auditing.</li>
                                                <li>Any other relevant quick-access icons depending on the role</li>
                                                </ul>`
                                            },
                                            {
                                                title: 'Frequently Asked Questions (FAQs)',
                                                content: `<ol class='list-decimal pl-6 space-y-1 text-sm text-primary-600'>
                                                <li><strong>Can I edit a report after submitting it?</strong><br>
                                                Office Users can edit certain reports after submission. Unit Users generally cannot edit a report once submitted, to preserve report integrity.</li>
                                                <li><strong>How long are submitted reports stored in the system?</strong><br>
                                                Reports are securely stored indefinitely unless deleted by an Admin.</li>
                                                <li><strong>Can I delete a report?</strong><br>
                                                Only Admin Users can delete reports. Office Users can manage (view/edit) reports but cannot delete them unless granted permission.</li>
                                                <li><strong>How do I export a report?</strong><br>
                                                Reports can be exported in Excel format using the Export button on the Manage Reports or individual Report view pages.</li>
                                                <li><strong>How does the session timeout work?</strong><br>
                                                Your session will automatically log out after 10 minutes of inactivity. You will need to log in again to continue.</li>
                                                <li><strong>I forgot my password. How can I reset it?</strong><br>
                                                Go to the Login Page and click on Forgot Password. You will receive a reset link via your registered email.</li>
                                                <li><strong>Who can create new user accounts?</strong><br>
                                                Only Admin Users can create new user accounts and manage user roles.</li>
                                                <li><strong>What reports can I create?</strong><br>
                                                You can create Noon, Departure, Arrival, Bunkering, All Fast, Weekly Schedule, Crew Monitoring, Voyage, KPI, and Port of Call reports.</li>
                                                <li><strong>Can I access the system from any device?</strong><br>
                                                Yes, the application is web-based and works on desktop, laptop, tablet, and mobile devices. For best experience, use a desktop or laptop.</li>
                                                <li><strong>What happens if I lose internet connection while working on a report?</strong><br>
                                                If your connection is lost before submitting, your work may not be saved unless you save it as a draft. It is recommended to save your work frequently.</li>
                                                </ol>`
                                            }
                                            ]
                                        " :key="idx">
                                    <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 mb-3">
                                        <button
                                            type="button"
                                            class="flex w-full items-center justify-between px-5 py-3 text-lg font-medium text-primary-800 hover:bg-primary-100 focus:outline-none transition"
                                            @click="open === idx ? open = null : open = idx"
                                            :aria-expanded="open === idx"
                                            :aria-controls="`accordion-content-${idx}`"
                                        >
                                            <flux:heading x-text="`${idx + 1}. ${item.title}`">Need Help?</flux:heading>
                                            <svg :class="open === idx ? 'rotate-180' : ''" class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                                        </button>
                                        <div
                                            x-show="open === idx"
                                            x-transition
                                            :id="`accordion-content-${idx}`"
                                            class="px-6 pb-4 text-primary-700"
                                            style="display: none;"
                                            x-html="item.content"
                                        ></div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </flux:modal>
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
