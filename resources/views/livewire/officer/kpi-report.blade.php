<div>
    <div class="flex flex-col gap-6 mb-6">
        <div class="flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
            <h1 class="text-3xl font-bold">
                KPI Reports
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
                <th class="px-3 py-3">Vessel</th>
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
                    <flux:dropdown>
                        <flux:button icon:trailing="ellipsis-horizontal" size="xs" variant="ghost" />

                        <flux:menu>
                            <flux:menu.radio.group>
                                <flux:modal.trigger name="view-voyage-{{ $report->id }}">
                                    <flux:menu.item icon="eye">
                                        View Details
                                    </flux:menu.item>
                                </flux:modal.trigger>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>

                    <flux:modal name="view-voyage-{{ $report->id }}" class="max-w-6xl">
                        <div class="space-y-6">
                            <flux:heading>KPI Report Details</flux:heading>

                            <!-- Bunkering -->
                            <flux:heading class="font-bold">Vessel Information</flux:heading>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <flux:label>Vessel</flux:label>
                                    <p class="text-sm">{{ $report->vessel->name ?? '' }}</p>
                                </div>

                                <div>
                                    <flux:label>Report Type</flux:label>
                                    <p class="text-sm">{{ $report->report_type ?? '' }}</p>
                                </div>
                                <div>
                                    <flux:label>Reporting Period</flux:label>
                                    <p class="text-sm">
                                        {{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '' }}
                                    </p>
                                </div>
                            </div>

                            <flux:separator />

                            <!-- Waste Management -->
                            @if ($report->waste)
                                <!-- Waste Management -->
                                <flux:heading>Waste Management</flux:heading>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="col-span-2">
                                        <flux:heading>Plastics</flux:heading>
                                    </div>
                                    <div>
                                        <flux:label>Total Landed Ashore (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->plastics_landed_ashore ?? '' }}</p>
                                    </div>

                                    <div>
                                        <flux:label>Total Incinerated (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->plastics_incinerated ?? '' }}</p>
                                    </div>

                                    <div class="col-span-2">
                                        <flux:separator class="my-3" />
                                    </div>

                                    <div class="col-span-2">
                                        <flux:heading>Food Waste</flux:heading>
                                    </div>
                                    <div>
                                        <flux:label>Total Disposed at Sea (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->food_disposed_sea ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Total Landed Ashore (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->food_landed_ashore ?? '' }}</p>
                                    </div>

                                    <div class="col-span-2">
                                        <flux:separator class="my-3" />
                                    </div>

                                    <div class="col-span-2">
                                        <flux:heading>Domestic Waste</flux:heading>
                                    </div>
                                    <div>
                                        <flux:label>Total Landed Ashore (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->domestic_landed_ashore ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Total Incinerated (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->domestic_incinerated ?? '' }}</p>
                                    </div>

                                    <div class="col-span-2">
                                        <flux:separator class="my-3" />
                                    </div>

                                    <div class="col-span-2">
                                        <flux:heading>Cooking Oil</flux:heading>
                                    </div>
                                    <div>
                                        <flux:label>Total Landed Ashore (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->cooking_oil_landed_ashore ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Total Incinerated (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->cooking_oil_incinerated ?? '' }}</p>
                                    </div>

                                    <div class="col-span-2">
                                        <flux:separator class="my-3" />
                                    </div>

                                    <div class="col-span-2">
                                        <flux:heading>Incinerator Ash</flux:heading>
                                    </div>
                                    <div>
                                        <flux:label>Total Landed Ashore (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->incinerator_ash_landed_ashore ?? '' }}
                                        </p>
                                    </div>
                                    <div>
                                        <flux:label>Total Incinerated (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->incinerator_ash_incinerated ?? '' }}</p>
                                    </div>

                                    <div class="col-span-2">
                                        <flux:separator class="my-3" />
                                    </div>

                                    <div class="col-span-2">
                                        <flux:heading>Operational Waste</flux:heading>
                                    </div>
                                    <div>
                                        <flux:label>Total Landed Ashore (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->operational_landed_ashore ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Total Incinerated (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->operational_incinerated ?? '' }}</p>
                                    </div>

                                    <div class="col-span-2">
                                        <flux:separator class="my-3" />
                                    </div>

                                    <div class="col-span-2">
                                        <flux:heading>E-Waste</flux:heading>
                                    </div>
                                    <div class="col-span-2">
                                        <flux:label>Total Landed Ashore (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->ewaste_landed_ashore ?? '' }}</p>
                                        <div class="col-span-2">
                                            <flux:separator class="my-3" />
                                        </div>
                                    </div>

                                    <div class="col-span-2">
                                        <flux:heading>Cargo Residues J/K</flux:heading>
                                    </div>
                                    <div class="col-span-2">
                                        <flux:label>Total Landed Ashore (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->cargo_residues_landed_ashore ?? '' }}
                                        </p>
                                    </div>
                                    <div class="col-span-2">
                                        <flux:separator class="my-3" />
                                    </div>

                                    <div class="col-span-2">
                                        <flux:heading>Total Garbage</flux:heading>
                                    </div>
                                    <div>
                                        <flux:label>Total Disposed at Sea (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->total_garbage_disposed_sea ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Total Garbage Landed Ashore (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->total_garbage_landed_ashore ?? '' }}</p>
                                    </div>

                                    <div class="col-span-2">
                                        <flux:separator class="my-3" />
                                    </div>

                                    <div class="col-span-2">
                                        <flux:heading>Sludge & Bunker</flux:heading>
                                    </div>
                                    <div>
                                        <flux:label>Total Landed Ashore (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->sludge_landed_ashore ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Total Incinerated (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->sludge_incinerated ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Total Quantity of Sludge Generated (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->sludge_generated ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Total Fuel Consumed (MT)</flux:label>
                                        <p class="text-sm">{{ $report->waste->fuel_consumed ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Ratio of Sludge Generated to Bunkers Consumed</flux:label>
                                        <p class="text-sm">{{ $report->waste->sludge_bunker_ratio ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Remarks (if target exceeded)</flux:label>
                                        <p class="text-sm whitespace-pre-line">{{ $report->waste->sludge_remarks }}
                                        </p>
                                    </div>

                                    <div class="col-span-2">
                                        <flux:separator class="my-3" />
                                    </div>

                                    <div class="col-span-2">
                                        <flux:heading>Bilge Water</flux:heading>
                                    </div>
                                    <div>
                                        <flux:label>Total Bilge Water Discharged Through OWS (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->bilge_discharged_ows ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Total Bilge Water Landed to Shore (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->bilge_landed_ashore ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Total Bilge Water Generated (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->bilge_generated ?? '' }}</p>
                                    </div>
                                    <div class="col-span-2">
                                        <flux:separator class="my-3" />
                                    </div>

                                    <div class="col-span-2">
                                        <flux:heading>Consumption</flux:heading>
                                    </div>
                                    <div>
                                        <flux:label>Paper Consumption (reams)</flux:label>
                                        <p class="text-sm">{{ $report->waste->paper_consumption ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Printer Cartridges (units)</flux:label>
                                        <p class="text-sm">{{ $report->waste->printer_cartridges ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Remarks (if target exceeded)</flux:label>
                                        <p class="text-sm whitespace-pre-line">
                                            {{ $report->waste->consumption_remarks }}</p>
                                    </div>

                                    <div class="col-span-2">
                                        <flux:separator class="my-3" />
                                    </div>

                                    <div class="col-span-2">
                                        <flux:heading>Fresh Water</flux:heading>
                                    </div>
                                    <div>
                                        <flux:label>Fresh Water Generated (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->fresh_water_generated ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Fresh Water Consumed (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->fresh_water_consumed ?? '' }}</p>
                                    </div>

                                    <div class="col-span-2">
                                        <flux:separator class="my-3" />
                                    </div>

                                    <div class="col-span-2">
                                        <flux:heading>Ballast Water</flux:heading>
                                    </div>
                                    <div>
                                        <flux:label>Number of Ballast Water Exchanges Performed</flux:label>
                                        <p class="text-sm">{{ $report->waste->ballast_exchanges ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Number of Ballast Operations</flux:label>
                                        <p class="text-sm">{{ $report->waste->ballast_operations ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Number of De-Ballast Operations</flux:label>
                                        <p class="text-sm">{{ $report->waste->deballast_operations ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Total Water Intake During Ballasting (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->ballast_intake ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Total Water Out During De-Ballasting (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->ballast_out ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Total Ballast Water Exchange Amount (m3)</flux:label>
                                        <p class="text-sm">{{ $report->waste->ballast_exchange_amount ?? '' }}</p>
                                    </div>

                                    <div class="col-span-2">
                                        <flux:separator class="my-3" />
                                    </div>

                                    <div class="col-span-2">
                                        <flux:heading>Hull Management</flux:heading>
                                    </div>
                                    <div>
                                        <flux:label>Total Number of Propeller Cleanings</flux:label>
                                        <p class="text-sm">{{ $report->waste->propeller_cleanings ?? '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Total Number of Hull Cleanings</flux:label>
                                        <p class="text-sm">{{ $report->waste->hull_cleanings ?? '' }}</p>
                                    </div>
                                </div>
                            @endif

                            <flux:separator />

                            <flux:heading>Sailing Days</flux:heading>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <flux:label>Total</flux:label>
                                    <p class="text-sm">{{ $report->call_sign ?? '' }}</p>
                                </div>
                                <div>
                                    <flux:label>Eco Speed</flux:label>
                                    <p class="text-sm">{{ $report->flag ?? '' }}</p>
                                </div>
                                <div>
                                    <flux:label>Full Speed</flux:label>
                                    <p class="text-sm">{{ $report->port_of_registry ?? '' }}</p>
                                </div>
                            </div>

                            <flux:separator />

                            <flux:heading>Crew Matter</flux:heading>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <flux:label>No. of Fatalities</flux:label>
                                    <p class="text-sm">{{ $report->official_number ?? '' }}</p>
                                </div>
                                <div>
                                    <flux:label>LTI (Lost Time Injuries)</flux:label>
                                    <p class="text-sm">{{ $report->imo_number ?? '' }}</p>
                                </div>
                                <div>
                                    <flux:label>No. of Recordable Injuries</flux:label>
                                    <p class="text-sm">{{ $report->class_society ?? '' }}</p>
                                </div>
                            </div>

                            <flux:separator />

                            <flux:heading>Corruption</flux:heading>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <flux:label>No. of Corruption/Bribery/Entertainment for Port Officials</flux:label>
                                    <p class="text-sm">{{ $report->class_no ?? '' }}</p>
                                </div>
                            </div>

                            <flux:separator />

                            <flux:heading>Inspection</flux:heading>
                            <div class="grid grid-cols-4 gap-4">
                                <div>
                                    <flux:label>Number of PSC Inspections</flux:label>
                                    <p class="text-sm">{{ $report->pi_club ?? '' }}</p>
                                </div>
                                <div>
                                    <flux:label>PSC No. of Deficiencies</flux:label>
                                    <p class="text-sm">{{ $report->loa ?? '' }}</p>
                                </div>
                                <div>
                                    <flux:label>PSC Detentions (if any)</flux:label>
                                    <p class="text-sm">{{ $report->lbp ?? '' }}</p>
                                </div>
                                <div>
                                    <flux:label>Number of Flag State Inspections</flux:label>
                                    <p class="text-sm">{{ $report->breadth_extreme ?? '' }}</p>
                                </div>
                                <div>
                                    <flux:label>Flag No. of Deficiencies</flux:label>
                                    <p class="text-sm">{{ $report->depth_moulded ?? '' }}</p>
                                </div>
                                <div>
                                    <flux:label>Third Party Inspections (Charterers, Owners, RISQ, Others)</flux:label>
                                    <p class="text-sm">{{ $report->height_maximum ?? '' }}</p>
                                </div>
                                <div>
                                    <flux:label>Third Party No. of Deficiencies</flux:label>
                                    <p class="text-sm">{{ $report->bridge_front_bow ?? '' }}</p>
                                </div>
                            </div>

                            <flux:separator />

                            <!-- Remarks -->
                            @if ($report->remarks)
                                <flux:heading>Overall Remarks</flux:heading>
                                <p class="text-sm whitespace-pre-line">{{ $report->remarks->remarks }}</p>
                            @endif

                            <flux:separator />

                            <!-- Master Information -->
                            @if ($report->master_info)
                                <flux:heading>Master Information</flux:heading>
                                <p class="text-sm whitespace-pre-line">{{ $report->master_info->master_info }}</p>
                            @endif

                            <div class="flex justify-end pt-4">
                                <flux:modal.close>
                                    <flux:button variant="primary">Close</flux:button>
                                </flux:modal.close>
                            </div>
                        </div>
                    </flux:modal>
                </td>
            </tr>
        @endforeach
    </x-admin-components.table>

    <div class="mt-6">
        {{ $reports->links() }}
    </div>
</div>
