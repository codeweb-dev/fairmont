<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">KPI Reports</h1>

        <div class="flex items-center gap-3">
            <div class="max-w-64">
                <flux:input wire:model.live="search" placeholder="Search by unit name..." icon="magnifying-glass" />
            </div>
            <div class="max-w-18">
                <flux:select wire:model.live="perPage" placeholder="Rows per page">
                    @foreach ($pages as $page)
                        <flux:select.option value="{{ $page }}">{{ $page }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            @if (count($selectedReports) > 0)
                <div>
                    <flux:button wire:click="exportSelected" icon:trailing="inbox-arrow-down" variant="filled">
                        Export Selected ({{ count($selectedReports) }})
                    </flux:button>
                </div>
            @endif

            <div>
                <flux:button href="{{ route('kpi') }}" wire:navigate icon:trailing="plus">
                    Create Report
                </flux:button>
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
                <th class="px-3 py-3">Unit</th>
                <th class="px-3 py-3">Date</th>
                <th class="px-3 py-3"></th>
            </tr>
        </thead>

        @foreach ($reports as $report)
            <tr class="hover:bg-white/5 bg-black/5 transition-all">
                <td class="px-3 py-4">
                    <flux:checkbox wire:model.live="selectedReports" value="{{ $report->id }}" />
                </td>
                <td class="px-3 py-4">{{ $report->report_type }}</td>
                <td class="px-3 py-4">{{ $report->vessel->name ?? '-' }}</td>
                <td class="px-3 py-4">{{ $report->unit->name ?? '-' }}</td>
                <td class="px-3 py-4">
                    {{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '-' }}
                </td>
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
                            <flux:heading>Voyage Report Details</flux:heading>

                            <!-- Bunkering -->
                            <flux:heading class="font-bold">Bunkering Details</flux:heading>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <flux:label>Vessel</flux:label>
                                    <p class="text-sm">{{ $report->vessel->name ?? '-' }}</p>
                                </div>

                                <div>
                                    <flux:label>Report Type</flux:label>
                                    <p class="text-sm">{{ $report->report_type ?? '-' }}</p>
                                </div>
                                <div>
                                    <flux:label>Date</flux:label>
                                    <p class="text-sm">
                                        {{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '-' }}
                                    </p>
                                </div>
                            </div>

                            <flux:separator />

                            <!-- Waste Management -->
                            @if ($report->waste)
                                <!-- Waste Management -->
                                <flux:heading>Waste Management</flux:heading>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <flux:label>Plastics Landed Ashore</flux:label>
                                        <p class="text-sm">{{ $report->waste->plastics_landed_ashore ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Plastics Incinerated</flux:label>
                                        <p class="text-sm">{{ $report->waste->plastics_incinerated ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Food Disposed at Sea</flux:label>
                                        <p class="text-sm">{{ $report->waste->food_disposed_sea ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Food Landed Ashore</flux:label>
                                        <p class="text-sm">{{ $report->waste->food_landed_ashore ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Domestic Landed Ashore</flux:label>
                                        <p class="text-sm">{{ $report->waste->domestic_landed_ashore ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Domestic Incinerated</flux:label>
                                        <p class="text-sm">{{ $report->waste->domestic_incinerated ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Cooking Oil Landed Ashore</flux:label>
                                        <p class="text-sm">{{ $report->waste->cooking_oil_landed_ashore ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Cooking Oil Incinerated</flux:label>
                                        <p class="text-sm">{{ $report->waste->cooking_oil_incinerated ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Incinerator Ash Landed Ashore</flux:label>
                                        <p class="text-sm">{{ $report->waste->incinerator_ash_landed_ashore ?? '-' }}
                                        </p>
                                    </div>
                                    <div>
                                        <flux:label>Incinerator Ash Incinerated</flux:label>
                                        <p class="text-sm">{{ $report->waste->incinerator_ash_incinerated ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Operational Landed Ashore</flux:label>
                                        <p class="text-sm">{{ $report->waste->operational_landed_ashore ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Operational Incinerated</flux:label>
                                        <p class="text-sm">{{ $report->waste->operational_incinerated ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>E-Waste Landed Ashore</flux:label>
                                        <p class="text-sm">{{ $report->waste->ewaste_landed_ashore ?? '-' }}</p>
                                    </div>
                                </div>

                                <flux:separator />

                                <!-- Cargo & Garbage -->
                                <flux:heading>Cargo & Garbage</flux:heading>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <flux:label>Cargo Residues Landed Ashore</flux:label>
                                        <p class="text-sm">{{ $report->waste->cargo_residues_landed_ashore ?? '-' }}
                                        </p>
                                    </div>
                                    <div>
                                        <flux:label>Total Garbage Disposed at Sea</flux:label>
                                        <p class="text-sm">{{ $report->waste->total_garbage_disposed_sea ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Total Garbage Landed Ashore</flux:label>
                                        <p class="text-sm">{{ $report->waste->total_garbage_landed_ashore ?? '-' }}</p>
                                    </div>
                                </div>

                                <flux:separator />

                                <!-- Sludge & Bunker -->
                                <flux:heading>Sludge & Bunker</flux:heading>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <flux:label>Sludge Landed Ashore</flux:label>
                                        <p class="text-sm">{{ $report->waste->sludge_landed_ashore ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Sludge Incinerated</flux:label>
                                        <p class="text-sm">{{ $report->waste->sludge_incinerated ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Sludge Generated</flux:label>
                                        <p class="text-sm">{{ $report->waste->sludge_generated ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Fuel Consumed</flux:label>
                                        <p class="text-sm">{{ $report->waste->fuel_consumed ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Sludge to Bunker Ratio</flux:label>
                                        <p class="text-sm">{{ $report->waste->sludge_bunker_ratio ?? '-' }}</p>
                                    </div>
                                </div>

                                <flux:separator />

                                @if ($report->waste->sludge_remarks)
                                    <div class="pt-2">
                                        <flux:label>Sludge Remarks</flux:label>
                                        <p class="text-sm whitespace-pre-line">{{ $report->waste->sludge_remarks }}</p>
                                    </div>
                                @endif

                                <!-- Bilge Water -->
                                <flux:heading>Bilge Water</flux:heading>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <flux:label>Bilge Discharged OWS</flux:label>
                                        <p class="text-sm">{{ $report->waste->bilge_discharged_ows ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Bilge Landed Ashore</flux:label>
                                        <p class="text-sm">{{ $report->waste->bilge_landed_ashore ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Bilge Generated</flux:label>
                                        <p class="text-sm">{{ $report->waste->bilge_generated ?? '-' }}</p>
                                    </div>
                                </div>

                                <flux:separator />

                                <!-- Consumption -->
                                <flux:heading>Consumption</flux:heading>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <flux:label>Paper Consumption</flux:label>
                                        <p class="text-sm">{{ $report->waste->paper_consumption ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Printer Cartridges</flux:label>
                                        <p class="text-sm">{{ $report->waste->printer_cartridges ?? '-' }}</p>
                                    </div>
                                </div>

                                <flux:separator />

                                @if ($report->waste->consumption_remarks)
                                    <div class="pt-2">
                                        <flux:label>Consumption Remarks</flux:label>
                                        <p class="text-sm whitespace-pre-line">
                                            {{ $report->waste->consumption_remarks }}</p>
                                    </div>
                                @endif

                                <flux:separator />

                                <!-- Fresh Water -->
                                <flux:heading>Fresh Water</flux:heading>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <flux:label>Fresh Water Generated</flux:label>
                                        <p class="text-sm">{{ $report->waste->fresh_water_generated ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Fresh Water Consumed</flux:label>
                                        <p class="text-sm">{{ $report->waste->fresh_water_consumed ?? '-' }}</p>
                                    </div>
                                </div>

                                <flux:separator />

                                <!-- Ballast Water -->
                                <flux:heading>Ballast Water</flux:heading>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <flux:label>Ballast Exchanges</flux:label>
                                        <p class="text-sm">{{ $report->waste->ballast_exchanges ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Ballast Operations</flux:label>
                                        <p class="text-sm">{{ $report->waste->ballast_operations ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>De-Ballast Operations</flux:label>
                                        <p class="text-sm">{{ $report->waste->deballast_operations ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Ballast Intake</flux:label>
                                        <p class="text-sm">{{ $report->waste->ballast_intake ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Ballast Out</flux:label>
                                        <p class="text-sm">{{ $report->waste->ballast_out ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Ballast Exchange Amount</flux:label>
                                        <p class="text-sm">{{ $report->waste->ballast_exchange_amount ?? '-' }}</p>
                                    </div>
                                </div>

                                <flux:separator />

                                <!-- Cleaning -->
                                <flux:heading>Cleaning</flux:heading>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <flux:label>Propeller Cleanings</flux:label>
                                        <p class="text-sm">{{ $report->waste->propeller_cleanings ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Hull Cleanings</flux:label>
                                        <p class="text-sm">{{ $report->waste->hull_cleanings ?? '-' }}</p>
                                    </div>
                                </div>
                            @endif

                            <flux:separator />

                            <flux:heading>Voyage Report</flux:heading>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <flux:label>Total Sailing Days</flux:label>
                                    <p class="text-sm">{{ $report->call_sign ?? '-' }}</p>
                                </div>
                                <div>
                                    <flux:label>Eco Speed Sailing Days</flux:label>
                                    <p class="text-sm">{{ $report->flag ?? '-' }}</p>
                                </div>
                                <div>
                                    <flux:label>Full Speed Sailing Days</flux:label>
                                    <p class="text-sm">{{ $report->port_of_registry ?? '-' }}</p>
                                </div>
                            </div>

                            <flux:separator />

                            <flux:heading>Crew</flux:heading>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <flux:label>No. of Fatalities</flux:label>
                                    <p class="text-sm">{{ $report->official_number ?? '-' }}</p>
                                </div>
                                <div>
                                    <flux:label>LTI (Lost Time Injuries)</flux:label>
                                    <p class="text-sm">{{ $report->imo_number ?? '-' }}</p>
                                </div>
                                <div>
                                    <flux:label>No. of Recordable Injuries</flux:label>
                                    <p class="text-sm">{{ $report->class_society ?? '-' }}</p>
                                </div>
                            </div>

                            <flux:separator />

                            <flux:heading>MACN</flux:heading>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <flux:label>No. of Corruption/Bribery/Entertainment for Port Officials</flux:label>
                                    <p class="text-sm">{{ $report->class_no ?? '-' }}</p>
                                </div>
                            </div>

                            <flux:separator />

                            <flux:heading>Inspection</flux:heading>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <flux:label>Number of PSC Inspections</flux:label>
                                    <p class="text-sm">{{ $report->pi_club ?? '-' }}</p>
                                </div>
                                <div>
                                    <flux:label>PSC No. of Deficiencies</flux:label>
                                    <p class="text-sm">{{ $report->loa ?? '-' }}</p>
                                </div>
                                <div>
                                    <flux:label>PSC Detentions (if any)</flux:label>
                                    <p class="text-sm">{{ $report->lbp ?? '-' }}</p>
                                </div>
                                <div>
                                    <flux:label>Number of Flag State Inspections</flux:label>
                                    <p class="text-sm">{{ $report->breadth_extreme ?? '-' }}</p>
                                </div>
                                <div>
                                    <flux:label>Number of Flag State Inspections</flux:label>
                                    <p class="text-sm">{{ $report->depth_moulded ?? '-' }}</p>
                                </div>
                                <div>
                                    <flux:label>Third Party Inspections (Charterers, Owners, RISQ, Others)</flux:label>
                                    <p class="text-sm">{{ $report->height_maximum ?? '-' }}</p>
                                </div>
                                <div>
                                    <flux:label>Third Party No. of Deficiencies</flux:label>
                                    <p class="text-sm">{{ $report->bridge_front_bow ?? '-' }}</p>
                                </div>
                            </div>

                            <flux:separator />


                            <!-- Master's Info -->
                            @if ($report->master_info)
                                <flux:heading>Master's Info</flux:heading>
                                <p class="text-sm whitespace-pre-line">{{ $report->master_info->master_info }}</p>
                            @endif

                            <flux:separator />

                            <!-- Remarks -->
                            @if ($report->remarks)
                                <flux:heading>Remarks</flux:heading>
                                <p class="text-sm whitespace-pre-line">{{ $report->remarks->remarks }}</p>
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
