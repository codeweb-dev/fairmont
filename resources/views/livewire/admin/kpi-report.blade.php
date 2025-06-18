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
        </div>
    </div>

    <x-admin-components.table :headers="['Report Type', 'Vessel', 'Unit', 'Date', '']">
        @foreach ($reports as $report)
            <tr class="hover:bg-white/5 bg-black/5 transition-all">
                <td class="px-3 py-4">{{ $report->report_type }}</td>
                <td class="px-3 py-4">{{ $report->vessel->name ?? '-' }}</td>
                <td class="px-3 py-4">{{ $report->unit->name ?? '-' }}</td>
                <td class="px-3 py-4">
                    {{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y') : '-' }}
                </td>
                <td class="px-3 py-4">
                    <flux:modal.trigger name="view-voyage-{{ $report->id }}">
                        <flux:button icon="eye" size="xs">View</flux:button>
                    </flux:modal.trigger>

                    <flux:modal name="view-voyage-{{ $report->id }}" class="max-w-6xl">
                        <div class="space-y-6">
                            <flux:heading>Voyage Report Details</flux:heading>

                            <!-- Bunkering -->
                            <flux:heading size="xl" class="font-bold">Bunkering Details</flux:heading>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <flux:label>Vessel</flux:label>
                                    <p class="text-sm">{{ $report->vessel->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <flux:label>Unit</flux:label>
                                    <p class="text-sm">{{ $report->unit->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <flux:label>Date</flux:label>
                                    <p class="text-sm">
                                        {{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y') : '-' }}
                                    </p>
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
