<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 items-center justify-between">
        <h1 class="text-3xl font-bold">Port Of Call Reports</h1>
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
                <td class="px-3 py-4">{{ $report->created_at->format('d M Y H:i') }}</td>
                <td class="px-3 py-4">
                    <flux:dropdown>
                        <flux:button icon:trailing="ellipsis-horizontal" size="xs" variant="ghost" />

                        <flux:menu>
                            <flux:menu.radio.group>
                                <flux:modal.trigger name="view-portofcall-{{ $report->id }}">
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

                    <flux:modal name="view-portofcall-{{ $report->id }}" class="w-full max-w-6xl">
                        <div class="space-y-6">
                            <flux:heading size="lg">Port Of Call Details</flux:heading>

                            <div class="grid grid-cols-4 gap-4">
                                <div>
                                    <flux:label>Vessel</flux:label>
                                    <p class="text-sm">{{ $report->vessel->name }}</p>
                                </div>
                                <div>
                                    <flux:label>Call Sign</flux:label>
                                    <p class="text-sm">{{ $report->call_sign }}</p>
                                </div>
                                <div>
                                    <flux:label>Flag</flux:label>
                                    <p class="text-sm">{{ $report->flag }}</p>
                                </div>
                                <div>
                                    <flux:label>Port of Registry</flux:label>
                                    <p class="text-sm">{{ $report->port_of_registry }}</p>
                                </div>
                                <div>
                                    <flux:label>Official Number</flux:label>
                                    <p class="text-sm">{{ $report->official_number }}</p>
                                </div>
                                <div>
                                    <flux:label>IMO Number</flux:label>
                                    <p class="text-sm">{{ $report->imo_number }}</p>
                                </div>
                                <div>
                                    <flux:label>Class Society</flux:label>
                                    <p class="text-sm">{{ $report->class_society }}</p>
                                </div>
                                <div>
                                    <flux:label>Class No</flux:label>
                                    <p class="text-sm">{{ $report->class_no }}</p>
                                </div>
                                <div>
                                    <flux:label>P&I Club</flux:label>
                                    <p class="text-sm">{{ $report->pi_club }}</p>
                                </div>
                                <div>
                                    <flux:label>LOA</flux:label>
                                    <p class="text-sm">{{ $report->loa }}</p>
                                </div>
                                <div>
                                    <flux:label>LBP</flux:label>
                                    <p class="text-sm">{{ $report->lbp }}</p>
                                </div>
                                <div>
                                    <flux:label>Breadth (Extreme)</flux:label>
                                    <p class="text-sm">{{ $report->breadth_extreme }}</p>
                                </div>
                                <div>
                                    <flux:label>Depth (Moulded)</flux:label>
                                    <p class="text-sm">{{ $report->depth_moulded }}</p>
                                </div>
                                <div>
                                    <flux:label>Height (Maximum)</flux:label>
                                    <p class="text-sm">{{ $report->height_maximum }}</p>
                                </div>
                                <div>
                                    <flux:label>Bridge Front Bow</flux:label>
                                    <p class="text-sm">{{ $report->bridge_front_bow }}</p>
                                </div>
                                <div>
                                    <flux:label>Bridge Front Stern</flux:label>
                                    <p class="text-sm">{{ $report->bridge_front_stern }}</p>
                                </div>
                                <div>
                                    <flux:label>Light Ship Displacement</flux:label>
                                    <p class="text-sm">{{ $report->light_ship_displacement }}</p>
                                </div>
                                <div>
                                    <flux:label>Keel Laid</flux:label>
                                    <p class="text-sm">{{ $report->keel_laid }}</p>
                                </div>
                                <div>
                                    <flux:label>Launched</flux:label>
                                    <p class="text-sm">{{ $report->launched }}</p>
                                </div>
                                <div>
                                    <flux:label>Delivered</flux:label>
                                    <p class="text-sm">{{ $report->delivered }}</p>
                                </div>
                                <div>
                                    <flux:label>Shipyard</flux:label>
                                    <p class="text-sm">{{ $report->shipyard }}</p>
                                </div>
                            </div>

                            @if ($report->master_info)
                                <div>
                                    <flux:label>Master's Info</flux:label>
                                    <p class="text-sm whitespace-pre-line">{{ $report->master_info->master_info }}</p>
                                </div>
                            @endif

                            @foreach ($report->ports as $pIndex => $port)
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
                                            <flux:heading size="xs">Agent(s)</flux:heading>
                                            <div class="grid grid-cols-3 gap-3">
                                                @foreach ($port->agents as $agent)
                                                    <div
                                                        class="border dark:border-zinc-700 border-zinc-300 p-3 rounded-md">
                                                        <p><strong>Port of Calling:</strong>
                                                            {{ $agent->port_of_calling }}</p>
                                                        <p><strong>Country:</strong> {{ $agent->country }}</p>
                                                        <p><strong>Purpose:</strong> {{ $agent->purpose }}</p>
                                                        <p><strong>ATA/ETA Date:</strong> {{ $agent->ata_eta_date }}
                                                        </p>
                                                        <p><strong>ATA/ETA Time:</strong> {{ $agent->ata_eta_time }}
                                                        </p>
                                                        <p><strong>Ship Info Date:</strong>
                                                            {{ $agent->ship_info_date }}</p>
                                                        <p><strong>Ship Info Time:</strong>
                                                            {{ $agent->ship_info_time }}</p>
                                                        <p><strong>GMT:</strong> {{ $agent->gmt }}</p>
                                                        <p><strong>Duration (Days):</strong>
                                                            {{ $agent->duration_days }}</p>
                                                        <p><strong>Total (Days):</strong> {{ $agent->total_days }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                            <div class="flex justify-end pt-6">
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
                                    Are you sure you want to delete the Port Of Call Report for
                                    <strong>{{ $report->vessel->name }}</strong> on
                                    <strong>{{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y') : 'N/A' }}</strong>?
                                    This report will not be permanently deleted and can be restored if needed.
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

    <div class="mt-6">{{ $reports->links() }}</div>
</div>
