<div>
    <div class="flex flex-col gap-6 mb-6">
        <div class="flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
            <h1 class="text-3xl font-bold">
                Port Of Call Reports
            </h1>

            <div class="flex items-center gap-3">
                <div class="max-w-64">
                    <flux:input wire:model.live="search" placeholder="Search by keyword" icon="magnifying-glass" />
                </div>
                @if (count($officerVessels) > 1)
                    <div class="max-w-64">
                        <flux:select wire:model.live="selectedVessel" placeholder="Filter by Vessel">
                            <flux:select.option value="">All Vessels</flux:select.option>
                            @foreach ($officerVessels as $id => $name)
                                <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>
                @endif
                <div class="max-w-18">
                    <flux:select wire:model.live="perPage" placeholder="Rows per page">
                        @foreach ($pages as $page)
                            <flux:select.option value="{{ $page }}">{{ $page }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>
        </div>

        <div class="flex gap-3 justify-end items-center w-full">
            @if (count($selectedReports) > 0 && !$dateRange)
                <div>
                    <flux:button wire:click="exportSelected" icon:trailing="inbox-arrow-down" variant="filled">
                        Export Selected ({{ count($selectedReports) }})
                    </flux:button>
                </div>
            @endif

            @if ($dateRange)
                <flux:button wire:click="exportByDateRange" icon:trailing="arrow-down-tray">
                    Export by Date Range
                </flux:button>
            @endif

            @if ($dateRange)
                <div>
                    <flux:button wire:click="$set('dateRange', null)" variant="danger" icon="x-circle">
                        Clear Filter
                    </flux:button>
                </div>
            @endif

            <div x-data="{ fp: null }" x-init="fp = flatpickr($refs.rangeInput, {
                mode: 'range',
                dateFormat: 'Y-m-d',
                onChange: function(selectedDates, dateStr) {
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
                x-effect="
        if ($wire.dateRange === null && fp) {
            fp.clear();
        }
     "
                wire:ignore>
                <input x-ref="rangeInput" type="text"
                    class="form-input w-full border rounded-lg block disabled:shadow-none dark:shadow-none text-base sm:text-sm py-2 h-10 leading-[1.375rem] ps-3 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5"
                    placeholder="Select Date Range">
            </div>
        </div>
    </div>

    <x-admin-components.table>
        <thead class="border-b dark:border-white/10 border-black/10 hover:bg-white/5 bg-black/5 transition-all">
            <tr>
                <th class="px-3 py-3">
                    <flux:checkbox wire:model.live="selectAll" />
                </th>
                <th class="px-3 py-3">Report Type</th>
                <th class="px-3 py-3">Vessel Name</th>
                <th class="px-3 py-3">Created Date</th>
                <th class="px-3 py-3">Vessel User</th>
                <th class="px-3 py-3"></th>
            </tr>
        </thead>

        @if ($reports->isEmpty())
            <tr>
                <td colspan="8" class="text-center text-zinc-500 py-10">
                    <div class="flex flex-col items-center space-y-2">
                        <flux:icon.archive-box-x-mark class="size-12" />

                        <flux:heading>No reports found.</flux:heading>
                        <flux:text class="mt-1 text-center max-w-sm">
                            Try adding a new report or adjusting your search or date range
                            filter.
                        </flux:text>
                    </div>
                </td>
            </tr>
        @endif
        @foreach ($reports as $report)
            <tr class="hover:bg-white/5 bg-black/5 transition-all">
                <td class="px-3 py-4">
                    <flux:checkbox wire:model.live="selectedReports" value="{{ $report->id }}" />
                </td>
                <td class="px-3 py-4">{{ $report->report_type }}</td>
                <td class="px-3 py-4">{{ $report->vessel->name }}</td>
                <td class="px-3 py-4">
                    {{ \Carbon\Carbon::parse($report->created_at)->timezone('Asia/Manila')->format('M d, Y h:i A') }}
                </td>
                <td class="px-3 py-4">{{ $report->unit->name }}</td>
                <td class="px-3 py-4">
                    <flux:button size="xs" icon="eye" wire:click="openReportModal({{ $report->id }})">View
                        Details</flux:button>
                </td>
            </tr>
        @endforeach
    </x-admin-components.table>

    <div class="mt-6">{{ $reports->links() }}</div>

    @if ($showModal && $selectedReport)
        <flux:modal name="report-details-modal" class="w-full max-w-6xl" wire:model="showModal">
            <div class="space-y-6">
                <flux:heading size="lg">Port Of Call Details</flux:heading>

                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <flux:label>Vessel Name</flux:label>
                        <p class="text-sm">{{ $selectedReport->vessel->name }}</p>
                    </div>
                    <div>
                        <flux:label>Call Sign</flux:label>
                        <p class="text-sm">{{ $selectedReport->call_sign }}</p>
                    </div>
                    <div>
                        <flux:label>Flag</flux:label>
                        <p class="text-sm">{{ $selectedReport->flag }}</p>
                    </div>
                    <div>
                        <flux:label>Port of Registry</flux:label>
                        <p class="text-sm">{{ $selectedReport->port_of_registry }}</p>
                    </div>
                    <div>
                        <flux:label>Official Number</flux:label>
                        <p class="text-sm">{{ $selectedReport->official_number }}</p>
                    </div>
                    <div>
                        <flux:label>IMO Number</flux:label>
                        <p class="text-sm">{{ $selectedReport->imo_number }}</p>
                    </div>
                    <div>
                        <flux:label>Class Society</flux:label>
                        <p class="text-sm">{{ $selectedReport->class_society }}</p>
                    </div>
                    <div>
                        <flux:label>Class No</flux:label>
                        <p class="text-sm">{{ $selectedReport->class_no }}</p>
                    </div>
                    <div>
                        <flux:label>P&I Club</flux:label>
                        <p class="text-sm">{{ $selectedReport->pi_club }}</p>
                    </div>
                    <div>
                        <flux:label>LOA (Length Overall)</flux:label>
                        <p class="text-sm">{{ $selectedReport->loa }}</p>
                    </div>
                    <div>
                        <flux:label>LBP (Length Between Perpendiculars)</flux:label>
                        <p class="text-sm">{{ $selectedReport->lbp }}</p>
                    </div>
                    <div>
                        <flux:label>Breadth (Extreme)</flux:label>
                        <p class="text-sm">{{ $selectedReport->breadth_extreme }}</p>
                    </div>
                    <div>
                        <flux:label>Depth (Moulded)</flux:label>
                        <p class="text-sm">{{ $selectedReport->depth_moulded }}</p>
                    </div>
                    <div>
                        <flux:label>Height (Maximum)</flux:label>
                        <p class="text-sm">{{ $selectedReport->height_maximum }}</p>
                    </div>
                    <div>
                        <flux:label>Bridge Front Bow</flux:label>
                        <p class="text-sm">{{ $selectedReport->bridge_front_bow }}</p>
                    </div>
                    <div>
                        <flux:label>Bridge Front Stern</flux:label>
                        <p class="text-sm">{{ $selectedReport->bridge_front_stern }}</p>
                    </div>
                    <div>
                        <flux:label>Light Ship Displacement</flux:label>
                        <p class="text-sm">{{ $selectedReport->light_ship_displacement }}</p>
                    </div>
                    <div>
                        <flux:label>Keel Laid</flux:label>
                        <p class="text-sm">
                            {{ $selectedReport->keel_laid ? \Carbon\Carbon::parse($selectedReport->keel_laid)->format('M d, Y h:i A') : '' }}
                        </p>
                    </div>
                    <div>
                        <flux:label>Launched</flux:label>
                        <p class="text-sm">
                            {{ $selectedReport->launched ? \Carbon\Carbon::parse($selectedReport->launched)->format('M d, Y h:i A') : '' }}
                        </p>
                    </div>
                    <div>
                        <flux:label>Delivered</flux:label>
                        <p class="text-sm">
                            {{ $selectedReport->delivered ? \Carbon\Carbon::parse($selectedReport->delivered)->format('M d, Y h:i A') : '' }}
                        </p>
                    </div>
                    <div>
                        <flux:label>Shipyard</flux:label>
                        <p class="text-sm">
                            {{ $selectedReport->shipyard }}
                        </p>
                    </div>
                </div>

                @foreach ($selectedReport->ports as $pIndex => $port)
                    <div>
                        <flux:separator class="my-4" />
                        <div class="grid grid-cols-3 gap-4 mt-2">
                            <div>
                                <flux:label>Voyage No</flux:label>
                                <p class="text-sm">{{ $port->voyage_no }}</p>
                            </div>
                            <div>
                                <flux:label>Cargo</flux:label>
                                <p class="text-sm">{{ $port->cargo }}</p>
                            </div>
                            <div>
                                <flux:label>Charterers</flux:label>
                                <p class="text-sm">{{ $port->charterers }}</p>
                            </div>
                        </div>
                        @if ($port->agents->isNotEmpty())
                            <div class="pt-4">
                                <flux:heading size="xs">Port of Call(s)</flux:heading>
                                <div class="grid grid-cols-3 gap-3">
                                    @foreach ($port->agents as $agent)
                                        <div class="border dark:border-zinc-700 border-zinc-300 p-3 rounded-md">
                                            <p><strong>Port of Calling:</strong>
                                                {{ $agent->port_of_calling }}</p>
                                            <p><strong>Country:</strong> {{ $agent->country }}</p>
                                            <p><strong>Purpose:</strong> {{ $agent->purpose }}</p>
                                            <p><strong>ATA/ETA Date:</strong>
                                                {{ $agent->ata_eta_date ? \Carbon\Carbon::parse($agent->ata_eta_date)->format('M d, Y h:i A') : '' }}
                                            </p>
                                            <p><strong>Ship Info Date:</strong>
                                                {{ $agent->ship_info_date ? \Carbon\Carbon::parse($agent->ship_info_date)->format('M d, Y h:i A') : '' }}
                                            </p>
                                            <p><strong>GMT:</strong> {{ $agent->gmt }}</p>
                                            <p><strong>Duration (Days):</strong>
                                                {{ $agent->duration_days ?: '' }}
                                            </p>
                                            <p><strong>Total (Days):</strong>
                                                {{ $agent->total_days ?: '' }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach

                <flux:separator />

                <!-- Remarks -->
                @if ($selectedReport->remarks)
                    <flux:label>Remarks</flux:label>
                    <p class="text-sm whitespace-pre-line">{{ $selectedReport->remarks->remarks }}</p>
                @endif

                <flux:separator />

                @if ($selectedReport->master_info)
                    <div>
                        <flux:label>Master Information</flux:label>
                        <p class="text-sm whitespace-pre-line">{{ $selectedReport->master_info->master_info }}</p>
                    </div>
                @endif

                <div class="flex justify-end pt-6">
                    <flux:modal.close>
                        <flux:button variant="primary">Close</flux:button>
                    </flux:modal.close>
                </div>
            </div>
        </flux:modal>
    @endif
</div>
