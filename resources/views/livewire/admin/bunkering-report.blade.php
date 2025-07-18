<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">Bunker Reports</h1>

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
                <th class="px-3 py-3">Vessel</th>
                <th class="px-3 py-3">Voyage No</th>
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
                <td class="px-3 py-4">{{ $report->report_type }}</td>
                <td class="px-3 py-4">{{ $report->vessel->name }}</td>
                <td class="px-3 py-4">{{ $report->voyage_no }}</td>
                <td class="px-3 py-4">
                    {{ \Carbon\Carbon::parse($report->created_at)->timezone('Asia/Manila')->format('M d, Y h:i A') }}
                </td>
                <td class="px-3 py-4">{{ $report->unit->name }}</td>
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

                                <flux:modal.trigger name="delete-report-{{ $report->id }}">
                                    <flux:menu.item icon="trash" variant="danger">
                                        Delete
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
                                    <p class="text-sm">
                                        {{ \Carbon\Carbon::parse($report->port_etd)->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                                <div>
                                    <flux:label>Port GMT Offset</flux:label>
                                    <p class="text-sm">{{ $report->port_gmt_offset }}</p>
                                </div>
                                <div>
                                    <flux:label>Bunker Completed (LT)</flux:label>
                                    <p class="text-sm">
                                        {{ \Carbon\Carbon::parse($report->bunker_completed)->format('M d, Y h:i A') }}
                                    </p>
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
                                        <p class="text-sm">{{ $report->bunker->hsfo_quantity !== null ? rtrim(rtrim(number_format((float) $report->bunker->hsfo_quantity, 3, '.', ''), '0'), '.') : '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>HSFO Viscosity</flux:label>
                                        <p class="text-sm">{{ $report->bunker->hsfo_viscosity }}</p>
                                    </div>

                                    <div>
                                        <flux:label>BIOFUEL (MT)</flux:label>
                                        <p class="text-sm">{{ $report->bunker->biofuel_quantity !== null ? rtrim(rtrim(number_format((float) $report->bunker->biofuel_quantity, 3, '.', ''), '0'), '.') : '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>BIOFUEL Viscosity</flux:label>
                                        <p class="text-sm">{{ $report->bunker->biofuel_viscosity }}</p>
                                    </div>

                                    <div>
                                        <flux:label>VLSFO (MT)</flux:label>
                                        <p class="text-sm">{{ $report->bunker->vlsfo_quantity !== null ? rtrim(rtrim(number_format((float) $report->bunker->vlsfo_quantity, 3, '.', ''), '0'), '.') : '' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>VLSFO Viscosity</flux:label>
                                        <p class="text-sm">{{ $report->bunker->vlsfo_viscosity }}</p>
                                    </div>

                                    <div>
                                        <flux:label>LSMGO (MT)</flux:label>
                                        <p class="text-sm">{{ $report->bunker->lsmgo_quantity !== null ? rtrim(rtrim(number_format((float) $report->bunker->lsmgo_quantity, 3, '.', ''), '0'), '.') : '' }}</p>
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
                                        <p class="text-sm">
                                            {{ $report->assiociated_information->eosp ? \Carbon\Carbon::parse($report->assiociated_information->eosp)->format('M d, Y h:i A') : '' }}
                                        </p>
                                    </div>
                                    <div>
                                        <flux:label>EOSP GMT</flux:label>
                                        <p class="text-sm">{{ $report->assiociated_information->eosp_gmt }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Barge Alongside</flux:label>
                                        <p class="text-sm">
                                            {{ $report->assiociated_information->barge ? \Carbon\Carbon::parse($report->assiociated_information->barge)->format('M d, Y h:i A') : '' }}
                                        </p>
                                    </div>
                                    <div>
                                        <flux:label>Barge GMT</flux:label>
                                        <p class="text-sm">{{ $report->assiociated_information->barge_gmt }}</p>
                                    </div>
                                    <div>
                                        <flux:label>COSP</flux:label>
                                        <p class="text-sm">
                                            {{ $report->assiociated_information->cosp ? \Carbon\Carbon::parse($report->assiociated_information->cosp)->format('M d, Y h:i A') : '' }}
                                        </p>
                                    </div>
                                    <div>
                                        <flux:label>COSP GMT</flux:label>
                                        <p class="text-sm">{{ $report->assiociated_information->cosp_gmt }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Anchor Dropped</flux:label>
                                        <p class="text-sm">
                                            {{ $report->assiociated_information->anchor ? \Carbon\Carbon::parse($report->assiociated_information->anchor)->format('M d, Y h:i A') : '' }}
                                        </p>
                                    </div>
                                    <div>
                                        <flux:label>Anchor GMT</flux:label>
                                        <p class="text-sm">{{ $report->assiociated_information->anchor_gmt }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Pumping Completed</flux:label>
                                        <p class="text-sm">
                                            {{ $report->assiociated_information->pumping ? \Carbon\Carbon::parse($report->assiociated_information->pumping)->format('M d, Y h:i A') : '' }}
                                        </p>
                                    </div>
                                    <div>
                                        <flux:label>Pumping GMT</flux:label>
                                        <p class="text-sm">{{ $report->assiociated_information->pumping_gmt }}</p>
                                    </div>
                                </div>
                            @endif

                            <flux:separator />

                            @if ($report->remarks)
                                <div class="pt-4">
                                    <flux:heading size="sm">Remarks</flux:heading>
                                    <p class="text-sm whitespace-pre-line">{{ $report->remarks->remarks }}</p>
                                </div>
                            @endif

                            <flux:separator />

                            @if ($report->master_info)
                                <div class="pt-4">
                                    <flux:heading size="sm">Master Information</flux:heading>
                                    <p class="text-sm whitespace-pre-line">{{ $report->master_info->master_info }}</p>
                                </div>
                            @endif

                            <div class="flex justify-end pt-4">
                                <flux:modal.close>
                                    <flux:button variant="primary">Close</flux:button>
                                </flux:modal.close>
                            </div>
                        </div>
                    </flux:modal>

                    <flux:modal name="delete-report-{{ $report->id }}" class="min-w-[22rem]">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Soft Delete Report?</flux:heading>
                                <flux:text class="mt-2">
                                    Are you sure you want to delete the Bunkering Report? <br> This report will not be permanently deleted and can be restored if needed.
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

    <div class="mt-6">
        {{ $reports->links() }}
    </div>
</div>
