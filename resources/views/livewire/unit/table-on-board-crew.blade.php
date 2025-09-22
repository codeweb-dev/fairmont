<div>
    <div class="flex flex-col gap-6 mb-6">
        <div class="flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
            <h1 class="text-3xl font-bold">
                On Board Crew Reports
            </h1>

            <div class="flex items-center gap-3">
                <div class="max-w-64">
                    <flux:input wire:model.live="search" placeholder="Search by keyword" icon="magnifying-glass" />
                </div>
                <div class="max-w-18">
                    <flux:select wire:model.live="perPage" placeholder="Rows per page">
                        @foreach ($pages as $page)
                            <flux:select.option value="{{ $page }}">{{ $page }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

                <div>
                    <flux:button href="{{ route('crew-monitoring-plan') }}" wire:navigate icon:trailing="plus">
                        Create Report
                    </flux:button>
                </div>
            </div>
        </div>

        <div class="flex gap-3 justify-end items-center w-full">
            @php
                $activeSelectedReports = $selectedOnBoard ?? [];
            @endphp

            @if (count($activeSelectedReports ?? []) > 0 && !$dateRange)
                <div>
                    <flux:button wire:click="exportSelected" icon:trailing="inbox-arrow-down" variant="filled">
                        Export Selected ({{ count($activeSelectedReports) }})
                    </flux:button>
                </div>
            @endif

            @if ($dateRange)
                <flux:button wire:click="exportByDateRange" icon:trailing="arrow-down-tray">
                    Export by Date Range
                </flux:button>
                <div>
                    <flux:button wire:click="$set('dateRange', null)" variant="danger" icon="x-circle">
                        Clear Filter
                    </flux:button>
                </div>
            @endif

            <div x-data="{ fp: null }" x-init="fp = flatpickr($refs.rangeInput, {
                mode: 'range',
                dateFormat: 'Y-m-d',
                onChange: function(selectedDates) {
                    if (selectedDates.length === 1) {
                        const onlyDate = selectedDates[0];
                        const singleDate = flatpickr.formatDate(onlyDate, 'Y-m-d');
                        $wire.set('dateRange', `${singleDate} to ${singleDate}`);
                    } else if (selectedDates.length === 2) {
                        const start = flatpickr.formatDate(selectedDates[0], 'Y-m-d');
                        const end = flatpickr.formatDate(selectedDates[1], 'Y-m-d');
                        $wire.set('dateRange', `${start} to ${end}`);
                    } else {
                        $wire.set('dateRange', null);
                    }
                }
            });"
                x-effect="if ($wire.dateRange === null && fp) fp.clear()" wire:ignore>
                <input x-ref="rangeInput" type="text"
                    class="form-input w-full border rounded-lg block disabled:shadow-none dark:shadow-none text-base sm:text-sm py-2 h-10 leading-[1.375rem] ps-3 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5"
                    placeholder="Select Date Range">
            </div>
        </div>
    </div>

    <x-admin-components.table>
        <thead>
            <tr>
                <th class="px-3 py-3">
                    <flux:checkbox wire:model.live="selectAll" />
                </th>
                <th class="px-3 py-3">Report Type</th>
                <th class="px-3 py-3">Vessel Name</th>
                <th class="px-3 py-3">Crew Report Type</th>
                <th class="px-3 py-3">Created Date</th>
                <th class="px-3 py-3">Vessel User</th>
                <th class="px-3 py-3"></th>
            </tr>
        </thead>

        @if ($reports->isEmpty())
            <tr>
                <td colspan="7" class="text-center text-zinc-500 py-10">
                    <div class="flex flex-col items-center space-y-2">
                        <flux:icon.archive-box-x-mark class="size-12" />
                        <flux:heading>No reports found.</flux:heading>
                        <flux:text class="mt-1 text-center max-w-sm">
                            Try adding a new report or adjusting your search or date range filter.
                        </flux:text>
                    </div>
                </td>
            </tr>
        @endif

        @foreach ($reports as $report)
            <tr class="hover:bg-white/5 bg-black/5 transition-all" wire:key="on-board-row-{{ $report->id }}">
                <td class="px-3 py-4">
                    <flux:checkbox wire:model.live="selectedOnBoard" value="{{ $report->id }}" />
                </td>
                <td class="px-3 py-4">{{ $report->report_type }}</td>
                <td class="px-3 py-4">{{ $report->vessel->name }}</td>
                <td class="px-3 py-4">
                    @if ($report->board_crew->isNotEmpty())
                        On Board Crew
                    @else
                        <span class="text-red-500 text-xs">⚠ No Data</span>
                    @endif
                </td>
                <td class="px-3 py-4">
                    {{ \Carbon\Carbon::parse($report->created_at)->timezone('Asia/Manila')->format('M d, Y h:i A') }}
                </td>
                <td class="px-3 py-4">{{ $report->unit->name }}</td>
                <td class="px-3 py-4 flex items-center gap-2">
                    <flux:dropdown>
                        <flux:button icon:trailing="ellipsis-horizontal" size="xs" variant="ghost" />
                        <flux:menu>
                            <flux:menu.radio.group>
                                <flux:modal.trigger name="view-report-{{ $report->id }}">
                                    <flux:menu.item icon="eye">View Details</flux:menu.item>
                                </flux:modal.trigger>

                                <flux:navmenu.item href="{{ route('on-board-report.edit', $report->id) }}"
                                    icon="pencil-square" wire:navigate>Edit</flux:navmenu.item>

                                <flux:modal.trigger name="delete-report-{{ $report->id }}">
                                    <flux:menu.item icon="trash" variant="danger">Delete</flux:menu.item>
                                </flux:modal.trigger>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>

                    <flux:modal name="view-report-{{ $report->id }}" class="min-w-[28rem] md:w-[48rem]"
                        wire:key="on-board-view-modal-{{ $report->id }}">
                        <div class="space-y-6">
                            <flux:heading size="lg">On Board Crew</flux:heading>
                            <div class="grid grid-cols-2 gap-4">
                                @foreach ($report->board_crew as $i => $crew)
                                    <div class="col-span-2">
                                        <flux:heading size="lg">Board Crew {{ $i + 1 }}</flux:heading>
                                    </div>
                                    <div>
                                        <flux:label>No</flux:label>
                                        <p class="text-sm">{{ $crew->no }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Vessel Name</flux:label>
                                        <p class="text-sm">{{ $crew->vessel_name }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Crew Surname</flux:label>
                                        <p class="text-sm">{{ $crew->crew_surname }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Crew First Name</flux:label>
                                        <p class="text-sm">{{ $crew->crew_first_name }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Rank</flux:label>
                                        <p class="text-sm">{{ $crew->rank }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Crew Nationality</flux:label>
                                        <p class="text-sm">{{ $crew->crew_nationality }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Joining Date</flux:label>
                                        <p class="text-sm">
                                            {{ $crew->joining_date ? \Carbon\Carbon::parse($crew->joining_date)->format('M d, Y h:i A') : '' }}
                                        </p>
                                    </div>
                                    <div>
                                        <flux:label>Contract Completion</flux:label>
                                        <p class="text-sm">
                                            {{ $crew->contract_completion ? \Carbon\Carbon::parse($crew->contract_completion)->format('M d, Y h:i A') : '' }}
                                        </p>
                                    </div>
                                    <div>
                                        <flux:label>Days to Completion</flux:label>
                                        <p class="text-sm">{{ $crew->days_contract_completion }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Months On Board</flux:label>
                                        <p class="text-sm">{{ $crew->months_on_board }}</p>
                                    </div>
                                    <div class="col-span-2">
                                        <flux:separator />
                                    </div>
                                @endforeach
                            </div>

                            <div>
                                <flux:label size="sm">Remarks</flux:label>
                                <p class="text-sm">{{ $report->remarks?->remarks }}</p>
                            </div>
                            <flux:separator />
                            <div>
                                <flux:label>Master Information</flux:label>
                                <p class="text-sm">{{ $report->master_info?->master_info }}</p>
                            </div>

                            <div class="flex justify-end pt-4">
                                <flux:modal.close>
                                    <flux:button variant="primary">Close</flux:button>
                                </flux:modal.close>
                            </div>
                        </div>
                    </flux:modal>

                    <flux:modal name="delete-report-{{ $report->id }}" class="min-w-[22rem]"
                        wire:key="delete-modal-{{ $report->id }}">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Soft Delete Report?</flux:heading>
                                <flux:text class="mt-2">
                                    Are you sure you want to delete this On Board Crew Report? This report will not be
                                    permanently deleted and can be restored.
                                </flux:text>
                            </div>

                            <div class="flex gap-2">
                                <flux:spacer />
                                <flux:modal.close>
                                    <flux:button variant="ghost">Cancel</flux:button>
                                </flux:modal.close>
                                <flux:button type="button" variant="danger" wire:click="delete({{ $report->id }})">
                                    Move to Trash
                                </flux:button>
                            </div>
                        </div>
                    </flux:modal>
                </td>
            </tr>
        @endforeach
    </x-admin-components.table>

    <div class="mt-6 flex items-center justify-between">
        <flux:text>
            Showing {{ $reports->firstItem() }} to {{ $reports->lastItem() }} of {{ $reports->total() }} results
        </flux:text>

        <div class="flex items-center gap-2">
            <flux:text>Page</flux:text>
            <div class="w-9">
                <flux:input size="sm" wire:model.lazy="currentPage" min="1"
                    max="{{ $reports->lastPage() }}" />
            </div>
            <flux:text>of {{ $reports->lastPage() }}</flux:text>
        </div>
    </div>
</div>
