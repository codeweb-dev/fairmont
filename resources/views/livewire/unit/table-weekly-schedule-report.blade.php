<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 items-center justify-between">
        <h1 class="text-3xl font-bold">Weekly Schedule Reports</h1>

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
                <flux:button href="{{ route('weekly-schedule') }}" wire:navigate icon:trailing="plus">
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
                <th class="px-3 py-3">Voyage No</th>
                <th class="px-3 py-3">All Fast Date</th>
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
                <td class="px-3 py-4">{{ $report->voyage_no }}</td>
                <td class="px-3 py-4">{{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') }}
                </td>
                <td class="px-3 py-4">
                    <flux:dropdown>
                        <flux:button icon:trailing="ellipsis-horizontal" size="xs" variant="ghost" />

                        <flux:menu>
                            <flux:menu.radio.group>
                                <flux:modal.trigger name="view-schedule-{{ $report->id }}">
                                    <flux:menu.item icon="eye">
                                        View Details
                                    </flux:menu.item>
                                </flux:modal.trigger>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>

                    <flux:modal name="view-schedule-{{ $report->id }}" class="w-full max-w-6xl">
                        <div class="space-y-6">
                            <flux:heading size="lg">Weekly Schedule Report Details</flux:heading>

                            <div class="grid grid-cols-3 gap-4">
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
                                    <flux:label>All Fast Date</flux:label>
                                    <p class="text-sm">
                                        {{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                            </div>

                            @foreach ($report->ports as $pIndex => $port)
                                <div>
                                    <flux:separator class="my-4" />
                                    <flux:heading size="sm">Port {{ $pIndex + 1 }} - {{ $port->port }}
                                    </flux:heading>

                                    <div class="grid grid-cols-3 gap-4 mt-2">
                                        <div>
                                            <flux:label>Activity</flux:label>
                                            <p class="text-sm">{{ $port->activity }}</p>
                                        </div>
                                        <div>
                                            <flux:label>ETA/ETB</flux:label>
                                            <p class="text-sm">
                                                {{ \Carbon\Carbon::parse($report->eta_etb)->format('M d, Y h:i A') }}
                                            </p>
                                        </div>
                                        <div>
                                            <flux:label>ETCD</flux:label>
                                            <p class="text-sm">
                                                {{ \Carbon\Carbon::parse($report->etcd)->format('M d, Y h:i A') }}
                                            </p>
                                        </div>
                                        <div>
                                            <flux:label>Cargo</flux:label>
                                            <p class="text-sm">{{ $port->cargo }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Cargo Qty</flux:label>
                                            <p class="text-sm">{{ $port->cargo_qty }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Remarks</flux:label>
                                            <p class="text-sm">{{ $port->remarks }}</p>
                                        </div>
                                    </div>

                                    @if ($port->agents->isNotEmpty())
                                        <div class="pt-4">
                                            <flux:heading size="xs">Agent(s)</flux:heading>
                                            <div class="grid grid-cols-3 gap-3">
                                                @foreach ($port->agents as $agent)
                                                    <div
                                                        class="border dark:border-zinc-700 border-zinc-300 p-3 rounded-md">
                                                        <p><strong>Name:</strong> {{ $agent->name }}</p>
                                                        <p><strong>Address:</strong> {{ $agent->address }}</p>
                                                        <p><strong>PIC:</strong> {{ $agent->pic_name }}</p>
                                                        <p><strong>Phone:</strong> {{ $agent->telephone }}</p>
                                                        <p><strong>Mobile:</strong> {{ $agent->mobile }}</p>
                                                        <p><strong>Email:</strong> {{ $agent->email }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                            <flux:separator />

                            @if ($report->master_info)
                                <div>
                                    <flux:label>Master's Info</flux:label>
                                    <p class="text-sm whitespace-pre-line">{{ $report->master_info->master_info }}</p>
                                </div>
                            @endif

                            <div class="flex justify-end pt-6">
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

    <div class="mt-6">{{ $reports->links() }}</div>
</div>
