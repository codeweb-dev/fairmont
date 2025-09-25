<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">Arrival Reports</h1>

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
        </div>
    </div>

    <x-admin-components.table>
        <thead class="border-b dark:border-white/10 border-black/10 hover:bg-white/5 bg-black/5 transition-all">
            <tr>
                <th class="px-3 py-3">Report Type</th>
                <th class="px-3 py-3">Vessel Name</th>
                <th class="px-3 py-3">Voyage No</th>
                <th class="px-3 py-3">Arrival Type</th>
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
            <tr class="hover:bg-white/5 bg-black/5 transition-all" wire:key="arrival-row-{{ $report->id }}">
                <td class="px-3 py-4">{{ $report->report_type }}</td>
                <td class="px-3 py-4">{{ $report->vessel->name }}</td>
                <td class="px-3 py-4">{{ $report->voyage_no }}</td>
                <td class="px-3 py-4">{{ $report->port_gmt_offset }}</td>
                <td class="px-3 py-4">
                    {{ \Carbon\Carbon::parse($report->created_at)->timezone('Asia/Manila')->format('M d, Y h:i A') }}
                </td>
                <td class="px-3 py-4">{{ $report->unit->name }}</td>
                </td>
                <td class="px-3 py-4">
                    <flux:dropdown>
                        <flux:button icon:trailing="ellipsis-horizontal" size="xs" variant="ghost" />

                        <flux:menu>
                            <flux:menu.radio.group>
                                <flux:modal.trigger name="view-arrival-{{ $report->id }}">
                                    <flux:menu.item icon="eye">
                                        View Details
                                    </flux:menu.item>
                                </flux:modal.trigger>

                                <flux:modal.trigger name="delete-report-{{ $report->id }}">
                                    <flux:menu.item icon="trash" variant="danger">
                                        Delete
                                    </flux:menu.item>
                                </flux:modal.trigger>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>

                    <flux:modal name="view-arrival-{{ $report->id }}" class="max-w-screen"
                        wire:key="arrival-view-modal-{{ $report->id }}">
                        <div class="space-y-6">
                            <flux:heading size="lg">Arrival Report Details</flux:heading>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <flux:label>Vessel Name</flux:label>
                                    <p class="text-sm">{{ $report->vessel->name }}</p>
                                </div>
                                <div>
                                    <flux:label>Voyage No</flux:label>
                                    <p class="text-sm">{{ $report->voyage_no }}</p>
                                </div>
                                <div>
                                    <flux:label>Date/Time (LT)</flux:label>
                                    <p class="text-sm">
                                        {{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                                <div>
                                    <flux:label>GMT Offset</flux:label>
                                    <p class="text-sm">{{ $report->gmt_offset }}</p>
                                </div>
                                <div>
                                    <flux:label>Latitude</flux:label>
                                    <p class="text-sm">{{ $report->port }}</p>
                                </div>
                                <div>
                                    <flux:label>Longitude</flux:label>
                                    <p class="text-sm">{{ $report->bunkering_port }}</p>
                                </div>
                                <div>
                                    <flux:label>Arrival Type</flux:label>
                                    <p class="text-sm">{{ $report->port_gmt_offset }}</p>
                                </div>
                                <div>
                                    <flux:label>Arrival Port</flux:label>
                                    <p class="text-sm">{{ $report->supplier }}</p>
                                </div>
                                <div>
                                    <flux:label>Anchored Hours</flux:label>
                                    <p class="text-sm">{{ $report->call_sign ?? '' }}</p>
                                </div>
                                <div>
                                    <flux:label>Drifting Hours</flux:label>
                                    <p class="text-sm">{{ $report->flag ?? '' }}</p>
                                </div>
                            </div>

                            <flux:separator />

                            @if ($report->noon_report)
                                <flux:heading size="sm">Details Since Last Report</flux:heading>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <flux:label>CP/Ordered Speed (Kts)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->cp_ordered_speed }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Allowed M/E Cons. at C/P Speed</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->me_cons_cp_speed }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Obs. Distance (NM)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->obs_distance }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Steaming Time (Hrs)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->steaming_time }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Avg Speed (Kts)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->avg_speed }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Distance sailed from last port (NM)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->distance_to_go }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Breakdown (Hrs)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->breakdown }}</p>
                                    </div>
                                    <div>
                                        <flux:label>M/E Revs Counter (Noon to Noon)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->maneuvering_hours }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Avg RPM</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->avg_rpm }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Engine Distance (NM)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->engine_distance }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Slip (%)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->next_port }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Avg Power (KW)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->avg_power }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Logged Distance (NM)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->logged_distance }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Speed Through Water (Kts)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->speed_through_water }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Course (Deg)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->course }}</p>
                                    </div>
                                </div>

                                <flux:separator />

                                <flux:heading size="sm">Arrival Conditions</flux:heading>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <flux:label>Condition</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->condition }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Displacement (MT)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->displacement }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Cargo Name</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->cargo_name }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Cargo Weight (MT)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->cargo_weight }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Ballast Weight (MT)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->ballast_weight }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Fresh Water (MT)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->fresh_water }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Fwd Draft (m)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->fwd_draft }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Aft Draft (m)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->aft_draft }}</p>
                                    </div>
                                    <div>
                                        <flux:label>GM</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->gm }}</p>
                                    </div>
                                </div>
                            @endif

                            <flux:separator />

                            <div class="overflow-x-auto mt-6">
                                <flux:label class="mb-6">ROB Summary</flux:label>
                                <table class="min-w-full border border-zinc-200 dark:border-zinc-700">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700 text-center"
                                                rowspan="2">Bunker Type</th>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700 text-center"
                                                colspan="2">ROB (in MT)</th>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700 text-center"
                                                colspan="4">Consumption</th>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700 text-center"
                                                colspan="2">Cons./24hr</th>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700 text-center"
                                                rowspan="2">Total Cons.</th>
                                        </tr>
                                        <tr class="border border-zinc-200 dark:border-zinc-700">
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Previous
                                            </th>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Current
                                            </th>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">M/E
                                                Propulsion</th>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">A/E Cons.
                                            </th>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Boiler
                                                Cons.</th>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                Incinerators</th>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">M/E 24hr
                                            </th>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">A/E 24hr
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($report->rob_fuel_reports as $summary)
                                            <tr class="border border-zinc-200 dark:border-zinc-700">
                                                <td
                                                    class="px-4 py-2 font-semibold border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->fuel_type }}
                                                </td>
                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->previous }}</td>
                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->current }}</td>
                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->me_propulsion }}</td>
                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->ae_cons }}</td>
                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->boiler_cons }}</td>
                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->incinerators }}</td>
                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->me_24 }}</td>
                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->ae_24 }}</td>
                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->total_cons }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Lube Oil Table -->
                            <div class="overflow-x-auto mt-10">
                                <table class="min-w-full border border-zinc-200 dark:border-zinc-700">
                                    <thead>
                                        <tr class="border-zinc-200 dark:border-zinc-700 text-center font-semibold">
                                            <td colspan="4"
                                                class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                ME CYL</td>
                                            <td colspan="3"
                                                class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                ME CC</td>
                                            <td colspan="3"
                                                class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                AE CC</td>
                                        </tr>
                                        <tr class="border border-zinc-200 dark:border-zinc-700">
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Oil Grade
                                            </th>

                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Oil
                                                Quantity</th>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Total
                                                Run Hrs.</th>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Oil Cons.
                                            </th>

                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Oil
                                                Quantity</th>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Total Run
                                                Hrs.</th>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Oil Cons.
                                            </th>

                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Oil
                                                Quantity</th>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Total Run
                                                Hrs.</th>
                                            <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Oil Cons.
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($report->rob_fuel_reports as $summary)
                                            <tr class="border border-zinc-200 dark:border-zinc-700">
                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->me_cyl_grade }}</td>

                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->me_cyl_qty }}</td>
                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->me_cyl_hrs }}</td>
                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->me_cyl_cons }}</td>

                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->me_cc_cons }}</td>
                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->me_cc_qty }}</td>
                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->me_cc_hrs }}</td>

                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->ae_cc_cons }}</td>
                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->ae_cc_qty }}</td>
                                                <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    {{ $summary->ae_cc_hrs }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <flux:separator />

                            @if ($report->remarks)
                                <flux:heading size="sm">Remarks</flux:heading>
                                <p class="text-sm whitespace-pre-line">{{ $report->remarks->remarks }}</p>
                            @endif

                            <flux:separator />

                            @if ($report->master_info)
                                <flux:heading size="sm">Master Information</flux:heading>
                                <p class="text-sm whitespace-pre-line">{{ $report->master_info->master_info }}</p>
                            @endif

                            <div class="flex justify-end pt-4">
                                <flux:modal.close>
                                    <flux:button variant="primary">Close</flux:button>
                                </flux:modal.close>
                            </div>
                        </div>
                    </flux:modal>

                    <flux:modal name="delete-report-{{ $report->id }}" class="min-w-[22rem]"
                        wire:key="arrival-delete-modal-{{ $report->id }}">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Soft Delete Report?</flux:heading>
                                <flux:text class="mt-2">
                                    Are you sure you want to delete the Arrival Report? <br> This report will not be
                                    permanently deleted and can be restored if needed.
                                </flux:text>
                            </div>

                            <div class="flex gap-2">
                                <flux:spacer />
                                <flux:modal.close>
                                    <flux:button variant="ghost">Cancel</flux:button>
                                </flux:modal.close>
                                <flux:button type="button" variant="danger"
                                    wire:click="delete({{ $report->id }})">
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
            <div class="w-12 overflow-hidden">
                <input type="text" max="{{ $reports->lastPage() }}" wire:model.lazy="currentPage"
                    class="form-input w-full border rounded-lg block disabled:shadow-none dark:shadow-none text-base sm:text-sm py-1 h-8 leading-[1.375rem] bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 text-center" />
            </div>
            <flux:text>of {{ $reports->lastPage() }}</flux:text>
        </div>
    </div>
</div>
