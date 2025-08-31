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
                @if (auth()->user()->hasRole('admin'))
                    <flux:navlist.item icon="home" :href="route('dashboard')"
                        :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}
                    </flux:navlist.item>

                    <flux:navlist.item icon="user" :href="route('users')" :current="request()->routeIs('users')"
                        wire:navigate>{{ __('User Management') }}</flux:navlist.item>

                    <flux:navlist.item icon="check-badge" :href="route('roles')" :current="request()->routeIs('roles')"
                        wire:navigate>{{ __('Role Management') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="ship" :href="route('vessel')" :current="request()->routeIs('vessel')"
                        wire:navigate>{{ __('Vessel Management') }}</flux:navlist.item>

                    <flux:navlist.item icon="document-magnifying-glass" :href="route('audit')"
                        :current="request()->routeIs('audit')" wire:navigate>{{ __('Audit Logs') }}</flux:navlist.item>

                    <flux:navlist.item icon="trash" :href="route('trash')" :current="request()->routeIs('trash')"
                        wire:navigate>{{ __('Trash Reports & Users') }}</flux:navlist.item>

                    <flux:navlist.group expandable heading="Report Management">
                        <flux:navlist.item href="{{ route('admin-total-report') }}"
                            :current="request()->routeIs('admin-total-report')" wire:navigate>Total Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('admin-noon-report') }}"
                            :current="request()->routeIs('admin-noon-report')" wire:navigate>Noon Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('admin-departure-report') }}"
                            :current="request()->routeIs('admin-departure-report')" wire:navigate>Departure Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('admin-arrival-report') }}"
                            :current="request()->routeIs('admin-arrival-report')" wire:navigate>Arrival Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('admin-bunkering-report') }}"
                            :current="request()->routeIs('admin-bunkering-report')" wire:navigate>Bunkering Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('admin-all-fast-report') }}"
                            :current="request()->routeIs('admin-all-fast-report')" wire:navigate>All Fast Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('admin-weekly-schedule-report') }}"
                            :current="request()->routeIs('admin-weekly-schedule-report')" wire:navigate>Weekly Schedule
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('admin-crew-monitoring-plan-report') }}"
                            :current="request()->routeIs('admin-crew-monitoring-plan-report')" wire:navigate>Crew
                            Monitoring Plan</flux:navlist.item>

                        <flux:navlist.item href="{{ route('admin-voyage-report') }}"
                            :current="request()->routeIs('admin-voyage-report')" wire:navigate>Voyage Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('admin-kpi-report') }}"
                            :current="request()->routeIs('admin-kpi-report')" wire:navigate>KPI Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('admin-port-of-call-report') }}"
                            :current="request()->routeIs('admin-port-of-call-report')" wire:navigate>Port of Call
                        </flux:navlist.item>
                    </flux:navlist.group>
                @elseif (auth()->user()->hasRole('unit'))
                    <flux:navlist.item icon="newspaper" :href="route('dashboard')"
                        :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}
                    </flux:navlist.item>

                    <flux:navlist.group expandable heading="Report Management">
                        <flux:navlist.item href="{{ route('total-report') }}"
                            :current="request()->routeIs('total-report')" wire:navigate>Total Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('table-noon-report') }}"
                            :current="request()->routeIs('table-noon-report')" wire:navigate>Noon Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('table-departure-report') }}"
                            :current="request()->routeIs('table-departure-report')" wire:navigate>Departure Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('table-arrival-report') }}"
                            :current="request()->routeIs('table-arrival-report')" wire:navigate>Arrival Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('table-bunkering-report') }}"
                            :current="request()->routeIs('table-bunkering-report')" wire:navigate>Bunkering Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('table-all-fast-report') }}"
                            :current="request()->routeIs('table-all-fast-report')" wire:navigate>All Fast Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('table-weekly-schedule-report') }}"
                            :current="request()->routeIs('table-weekly-schedule-report')" wire:navigate>Weekly Schedule
                        </flux:navlist.item>

                        <flux:navlist.group expandable heading="Crew Monitoring Plan">
                            <flux:navlist.item href="{{ route('table-crew-monitoring-plan-report-on-board-crew') }}"
                                :current="request()->routeIs('table-crew-monitoring-plan-report-on-board-crew')"
                                wire:navigate>On Board Crew</flux:navlist.item>

                            <flux:navlist.item href="{{ route('table-crew-monitoring-plan-report-crew-change') }}"
                                :current="request()->routeIs('table-crew-monitoring-plan-report-crew-change')"
                                wire:navigate>Crew Change</flux:navlist.item>
                        </flux:navlist.group>

                        <flux:navlist.item href="{{ route('table-voyage-report') }}"
                            :current="request()->routeIs('table-voyage-report')" wire:navigate>Voyage Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('table-kpi-report') }}"
                            :current="request()->routeIs('table-kpi-report')" wire:navigate>KPI Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('table-port-of-call-report') }}"
                            :current="request()->routeIs('table-port-of-call-report')" wire:navigate>Port of Call
                        </flux:navlist.item>
                    </flux:navlist.group>

                    {{-- <flux:navlist.item icon="newspaper" :href="route('table-noon-report')" :current="request()->routeIs('table-noon-report', 'noon-report')" wire:navigate>{{ __('Noon Report') }}
                </flux:navlist.item>

                <flux:navlist.item icon="newspaper" :href="route('table-departure-report')" :current="request()->routeIs('table-departure-report', 'departure-report')"
                    wire:navigate>{{ __('Departure Report') }}
                </flux:navlist.item>

                <flux:navlist.item icon="newspaper" :href="route('table-arrival-report')" :current="request()->routeIs('table-arrival-report', 'arrival-report')"
                    wire:navigate>{{ __('Arrival Report') }}
                </flux:navlist.item>

                <flux:navlist.item icon="newspaper" :href="route('table-bunkering-report')" :current="request()->routeIs('table-bunkering-report', 'bunkering')"
                    wire:navigate>{{ __('Bunkering Report') }}
                </flux:navlist.item>

                <flux:navlist.item icon="newspaper" :href="route('table-all-fast-report')" :current="request()->routeIs('table-all-fast-report', 'all-fast')"
                    wire:navigate>{{ __('All Fast Report') }}
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
                </flux:navlist.item> --}}
                @elseif (auth()->user()->hasRole('officer'))
                    <flux:navlist.item icon="newspaper" :href="route('dashboard')"
                        :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}
                    </flux:navlist.item>

                    <flux:navlist.group expandable heading="Report Management">
                        <flux:navlist.item href="{{ route('officer-total-report') }}"
                            :current="request()->routeIs('officer-total-report')" wire:navigate>Total Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('officer-noon-report') }}"
                            :current="request()->routeIs('officer-noon-report')" wire:navigate>Noon Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('officer-departure-report') }}"
                            :current="request()->routeIs('officer-departure-report')" wire:navigate>Departure Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('officer-arrival-report') }}"
                            :current="request()->routeIs('officer-arrival-report')" wire:navigate>Arrival Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('officer-bunkering-report') }}"
                            :current="request()->routeIs('officer-bunkering-report')" wire:navigate>Bunkering Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('officer-all-fast-report') }}"
                            :current="request()->routeIs('officer-all-fast-report')" wire:navigate>All Fast Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('officer-weekly-schedule-report') }}"
                            :current="request()->routeIs('officer-weekly-schedule-report')" wire:navigate>Weekly
                            Schedule</flux:navlist.item>

                        <flux:navlist.group expandable heading="Crew Monitoring Plan">
                            <flux:navlist.item href="{{ route('officer-crew-monitoring-plan-report-on-board-crew') }}"
                                :current="request()->routeIs('officer-crew-monitoring-plan-report-on-board-crew')"
                                wire:navigate>On Board Crew</flux:navlist.item>
                            <flux:navlist.item href="{{ route('officer-crew-monitoring-plan-report-crew-change') }}"
                                :current="request()->routeIs('officer-crew-monitoring-plan-report-crew-change')"
                                wire:navigate>Crew Change</flux:navlist.item>
                        </flux:navlist.group>

                        <flux:navlist.item href="{{ route('officer-voyage-report') }}"
                            :current="request()->routeIs('officer-voyage-report')" wire:navigate>Voyage Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('officer-kpi-report') }}"
                            :current="request()->routeIs('officer-kpi-report')" wire:navigate>KPI Report
                        </flux:navlist.item>

                        <flux:navlist.item href="{{ route('officer-port-of-call-report') }}"
                            :current="request()->routeIs('officer-port-of-call-report')" wire:navigate>Port of Call
                        </flux:navlist.item>
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
                    @unlessrole('admin')
                        <flux:menu.item icon="ship" class="capitalize">
                            {{ auth()->user()->vessels()->first()?->name ?? 'No vessel assigned' }}
                        </flux:menu.item>
                    @endunlessrole

                    <flux:menu.item icon="check-badge" class="capitalize">
                        {{ auth()->user()->getRoleNames()->first() ?? 'No role assigned' }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
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
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                            class="w-full">
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

                    @unlessrole('admin')
                        <livewire:notification />
                    @endunlessrole

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
                                <flux:text class="mt-2">Find quick answers and guides for the Fairmont Ship Reporting
                                    Tool.</flux:text>
                            </div>
                            <div x-data="{ open: null }" class="space-y-2">
                                <template
                                    x-for="(item, idx) in [
                                            {
                                                title: 'About Fairmont Ship Reporting Tool',
                                                content: `<p class='mt-2 text-sm text-primary-600 max-w-xl'>The Fairmont Ship Reporting Tool is a secure, web-based application designed to simplify the creation, management, and tracking of voyage reports for vessels.
                                                It supports both vessel crew and office staff, ensuring accurate, timely, and standardized reporting across all operations.</p>`
                                            },
                                            {
                                                title: 'Navigation Guide',
                                                content: `<ul class='list-disc pl-6 space-y-1 text-sm text-primary-600'>
                                                <li><strong>Dashboard:</strong> Provides a quick overview of reports and easy access to essential features.</li>
                                                <li><strong>Create Report:</strong> Start a new voyage, operational, or compliance report.</li>
                                                <li><strong>Manage Reports:</strong> View, edit, search, or manage all reports (based on your role and permissions).</li>
                                                <li><strong>Settings:</strong> Customize and view your profile, update passwords, and adjust appearance preferences.</li>
                                                </ul>`
                                            },
                                            {
                                                title: 'Creating Reports',
                                                content: `<ol class='list-decimal pl-6 space-y-1 text-sm text-primary-600'>
                                                <li>Navigate to Create Report</li>
                                                <li>Select the report type you want to create:
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
                                                <li>Complete all required fields (clearly marked).</li>
                                                <li>Review your entries carefully.</li>
                                                <li>Click Submit to finalize your report.</li>
                                                </ol>
                                                <p class='mt-2 text-sm text-primary-600'><span class='font-semibold'>Tip:</span> Always double-check your entries before submitting to avoid errors and corrections later.</p>`
                                            },
                                            {
                                                title: 'Managing Reports',
                                                content: `<ul class='list-disc pl-6 space-y-1 text-sm text-primary-600'>
                                                <li>From the Manage Reports section, you can:</li>
                                                <ul class='list-disc pl-6'>
                                                    <li>View all submitted reports.</li>
                                                    <li>Delete or archive reports (Admin only).</li>
                                                    <li>Search reports by type, date, reportee, or vessel.</li>
                                                </ul>
                                                </ul>`
                                            },
                                            {
                                                title: 'Exporting Reports',
                                                content: `<ul class='list-disc pl-6 space-y-1 text-sm text-primary-600'>
                                                <li>Reports can be exported in multiple formats:
                                                    <ul class='list-disc pl-6'>
                                                    <li>Excel (XLSX): For record-keeping or further editing</li>
                                                    </ul>
                                                </li>
                                                <li>Exports include all visible fields, tables, and properly formatted layouts for professional use.
                                                </li>
                                                </ul>`
                                            },
                                            {
                                                title: 'Security & Account Tips',
                                                content: `<ul class='list-disc pl-6 space-y-1 text-sm text-primary-600'>
                                                <li>Sessions automatically log out after 30 minutes of inactivity to keep your data secure.</li>
                                                <li>Choose a strong password containing:
                                                    <ul class='list-disc pl-6'>
                                                    <li>Minimum length requirement</li>
                                                    <li>Uppercase letters</li>
                                                    <li>Symbols</li>
                                                    </ul>
                                                </li>
                                                <li>If you forget your password, use the Forgot Password option on the login page.</li>
                                                <li>Admin users can review login history and activity logs for security audits.</li>
                                                <li>Additional quick-access icons or features may appear depending on your user role.</li>
                                                </ul>`
                                            },
                                            {
                                                title: 'Frequently Asked Questions (FAQs)',
                                                content: `<ol class='list-decimal pl-6 space-y-1 text-sm text-primary-600'>
                                                <li><strong>Can I edit a report after submitting it?</strong><br>
                                                Once a report has been submitted, it is considered final and cannot be freely edited by regular users. This is to ensure the accuracy and integrity of voyage data.</li>
                                                <li><strong>How long are submitted reports stored in the system?</strong><br>
                                                Reports are stored securely in the system indefinitely, unless deleted by an Admin.</li>
                                                <li><strong>Can I delete a report?</strong><br>
                                                Only Admin Users can delete reports. Office Users can manage (view/edit) reports but cannot delete them unless given explicit permission.</li>
                                                <li><strong>How do I export a report?</strong><br>
                                                Go to the Manage Reports or individual Report View page, then click the Export button. You can export reports in Excel format (XLSX), and in PDF if that feature is enabled.</li>
                                                <li><strong>How does the session timeout work?</strong><br>
                                                If your account is inactive for 30 minutes, the system will automatically log you out. You will need to log in again to continue working.</li>
                                                <li><strong>I forgot my password. How can I reset it?</strong><br>
                                                Click Forgot Password on the login page. A reset link will be sent to your registered email address.</li>
                                                <li><strong>Who can create new user accounts?</strong><br>
                                                Only Admin Users can create and manage user accounts, including assigning roles and vessel.</li>
                                                <li><strong>What reports can I create?</strong><br>
                                                You can create Noon, Departure, Arrival, Bunkering, All Fast, Weekly Schedule, Crew Monitoring, Voyage, KPI, and Port of Call reports.</li>
                                                <li><strong>Can I access the system from any device?</strong><br>
                                                Yes. The application is fully web-based and works on desktops, laptops, tablets, and smartphones. For the best experience, we recommend using a desktop or laptop.</li>
                                                <li><strong>What happens if I lose internet connection while working on a report?</strong><br>
                                                If your connection is interrupted before submission, your progress will be automatically saved and can be continue on your next login or session.</li>
                                                </ol>`
                                            }
                                            ]
                                        "
                                    :key="idx">
                                    <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 mb-3">
                                        <button type="button"
                                            class="flex w-full items-center justify-between px-5 py-3 text-lg font-medium text-primary-800 hover:bg-primary-100 focus:outline-none transition"
                                            @click="open === idx ? open = null : open = idx"
                                            :aria-expanded="open === idx" :aria-controls="`accordion-content-${idx}`">
                                            <flux:heading x-text="`${idx + 1}. ${item.title}`">Need Help?
                                            </flux:heading>
                                            <svg :class="open === idx ? 'rotate-180' : ''"
                                                class="w-5 h-5 transition-transform duration-200" fill="none"
                                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        <div x-show="open === idx" x-transition :id="`accordion-content-${idx}`"
                                            class="px-6 pb-4 text-primary-700" style="display: none;"
                                            x-html="item.content"></div>
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
                            <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'">Light
                            </flux:menu.item>
                            <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'">Dark
                            </flux:menu.item>
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
