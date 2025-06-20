<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">
            Bunker Reports
        </h1>

        <div class="flex items-center gap-3">
            <div class="max-w-64">
                <flux:input wire:model.live="search" placeholder="Search reports..." icon="magnifying-glass" />
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

    <x-admin-components.table :headers="[
        'Report Type',
        'Vessel',
        'Unit',
        'Voyage No',
        'Bunkering Port',
        'Supplier',
        'Port ETD (LT)',
        'Port GMT Offset',
        'Bunker Completed (LT)',
        'Bunker GMT Offset',
        '',
    ]">
        @foreach ($reports as $report)
            <tr class="hover:bg-white/5 bg-black/5 transition-all">
                <td class="px-3 py-4">{{ $report->report_type }}</td>
                <td class="px-3 py-4">{{ $report->vessel->name }}</td>
                <td class="px-3 py-4">{{ $report->unit->name }}</td>
                <td class="px-3 py-4">{{ $report->voyage_no }}</td>
                <td class="px-3 py-4">{{ $report->bunkering_port }}</td>
                <td class="px-3 py-4">{{ $report->supplier }}</td>
                <td class="px-3 py-4">
                    {{ $report->port_etd ? \Carbon\Carbon::parse($report->port_etd)->format('M d, Y') : '-' }}
                </td>
                <td class="px-3 py-4">{{ $report->port_gmt_offset }}</td>
                <td class="px-3 py-4">
                    {{ $report->bunker_completed ? \Carbon\Carbon::parse($report->bunker_completed)->format('M d, Y') : '-' }}
                </td>
                <td class="px-3 py-4">{{ $report->bunker_gmt_offset }}</td>
                <td class="px-3 py-4">
                    <flux:dropdown>
                        <flux:button icon:trailing="ellipsis-horizontal" size="xs" variant="ghost" />

                        <flux:menu>
                            <flux:menu.radio.group>
                                <flux:modal.trigger name="view-report-{{ $report->id }}">
                                    <flux:menu.item icon="eye">
                                        View Details
                                    </flux:menu.item>
                                </flux:modal.trigger>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>

                    <flux:modal name="view-report-{{ $report->id }}" class="min-w-[28rem] md:w-[48rem]">
                        <div class="space-y-6">
                            <flux:heading size="lg">Bunkering Report Details</flux:heading>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <flux:label>Vessel</flux:label>
                                    <p class="text-sm">{{ $report->vessel->name }}</p>
                                </div>
                                <div>
                                    <flux:label>Unit</flux:label>
                                    <p class="text-sm">{{ $report->unit->name }}</p>
                                </div>
                                <div>
                                    <flux:label>Voyage No</flux:label>
                                    <p class="text-sm">{{ $report->voyage_no }}</p>
                                </div>
                                <div>
                                    <flux:label>Bunkering Port</flux:label>
                                    <p class="text-sm">{{ $report->bunkering_port }}</p>
                                </div>
                                <div>
                                    <flux:label>Supplier</flux:label>
                                    <p class="text-sm">{{ $report->supplier }}</p>
                                </div>
                                <div>
                                    <flux:label>Port ETD (LT)</flux:label>
                                    <p class="text-sm">{{ $report->port_etd }}</p>
                                </div>
                                <div>
                                    <flux:label>Port GMT Offset</flux:label>
                                    <p class="text-sm">{{ $report->port_gmt_offset }}</p>
                                </div>
                                <div>
                                    <flux:label>Bunker Completed (LT)</flux:label>
                                    <p class="text-sm">{{ $report->bunker_completed }}</p>
                                </div>
                                <div>
                                    <flux:label>Bunker GMT Offset</flux:label>
                                    <p class="text-sm">{{ $report->bunker_gmt_offset }}</p>
                                </div>
                            </div>

                            <flux:separator />

                            @if ($report->bunker)
                                <div class="grid grid-cols-2 gap-4 pt-4">
                                    <flux:heading size="sm" class="col-span-2">Fuel Quantities & Viscosities
                                    </flux:heading>

                                    <div>
                                        <flux:label>HSFO (MT)</flux:label>
                                        <p class="text-sm">{{ $report->bunker->hsfo_quantity }}</p>
                                    </div>
                                    <div>
                                        <flux:label>HSFO Viscosity</flux:label>
                                        <p class="text-sm">{{ $report->bunker->hsfo_viscosity }}</p>
                                    </div>

                                    <div>
                                        <flux:label>BIOFUEL (MT)</flux:label>
                                        <p class="text-sm">{{ $report->bunker->biofuel_quantity }}</p>
                                    </div>
                                    <div>
                                        <flux:label>BIOFUEL Viscosity</flux:label>
                                        <p class="text-sm">{{ $report->bunker->biofuel_viscosity }}</p>
                                    </div>

                                    <div>
                                        <flux:label>VLSFO (MT)</flux:label>
                                        <p class="text-sm">{{ $report->bunker->vlsfo_quantity }}</p>
                                    </div>
                                    <div>
                                        <flux:label>VLSFO Viscosity</flux:label>
                                        <p class="text-sm">{{ $report->bunker->vlsfo_viscosity }}</p>
                                    </div>

                                    <div>
                                        <flux:label>LSMGO (MT)</flux:label>
                                        <p class="text-sm">{{ $report->bunker->lsmgo_quantity }}</p>
                                    </div>
                                    <div>
                                        <flux:label>LSMGO Viscosity</flux:label>
                                        <p class="text-sm">{{ $report->bunker->lsmgo_viscosity }}</p>
                                    </div>
                                </div>
                            @endif

                            <flux:separator />

                            @if ($report->assiociated_information)
                                <div class="grid grid-cols-2 gap-4 pt-4">
                                    <flux:heading size="sm" class="col-span-2">Associated Info</flux:heading>

                                    <div>
                                        <flux:label>Port Delivery</flux:label>
                                        <p class="text-sm">{{ $report->assiociated_information->port_delivery }}</p>
                                    </div>
                                    <div>
                                        <flux:label>EOSP</flux:label>
                                        <p class="text-sm">{{ $report->assiociated_information->eosp }}</p>
                                    </div>
                                    <div>
                                        <flux:label>EOSP GMT</flux:label>
                                        <p class="text-sm">{{ $report->assiociated_information->eosp_gmt }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Barge Alongside</flux:label>
                                        <p class="text-sm">{{ $report->assiociated_information->barge }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Barge GMT</flux:label>
                                        <p class="text-sm">{{ $report->assiociated_information->barge_gmt }}</p>
                                    </div>
                                    <div>
                                        <flux:label>COSP</flux:label>
                                        <p class="text-sm">{{ $report->assiociated_information->cosp }}</p>
                                    </div>
                                    <div>
                                        <flux:label>COSP GMT</flux:label>
                                        <p class="text-sm">{{ $report->assiociated_information->cosp_gmt }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Anchor Dropped</flux:label>
                                        <p class="text-sm">{{ $report->assiociated_information->anchor }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Anchor GMT</flux:label>
                                        <p class="text-sm">{{ $report->assiociated_information->anchor_gmt }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Pumping Completed</flux:label>
                                        <p class="text-sm">{{ $report->assiociated_information->pumping }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Pumping GMT</flux:label>
                                        <p class="text-sm">{{ $report->assiociated_information->pumping_gmt }}</p>
                                    </div>
                                </div>
                            @endif

                            <flux:separator />

                            @if ($report->master_info)
                                <div class="pt-4">
                                    <flux:heading size="sm">Master's Info</flux:heading>
                                    <p class="text-sm whitespace-pre-line">{{ $report->master_info->master_info }}</p>
                                </div>
                            @endif

                            <flux:separator />

                            @if ($report->remarks)
                                <div class="pt-4">
                                    <flux:heading size="sm">Remarks</flux:heading>
                                    <p class="text-sm whitespace-pre-line">{{ $report->remarks->remarks }}</p>
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
