<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">Weekly Schedule Reports</h1>

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
            <tr class="hover:bg-white/5 bg-black/5 transition-all" wire:key="weekly-row-{{ $report->id }}">
                <td class="px-3 py-4">{{ $report->report_type }}</td>
                <td class="px-3 py-4">{{ $report->vessel->name }}</td>
                <td class="px-3 py-4">{{ $report->voyage_no }}</td>
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
                                <flux:modal.trigger name="view-schedule-{{ $report->id }}">
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

                    <flux:modal name="view-schedule-{{ $report->id }}" class="w-full max-w-6xl"
                        wire:key="weekly-view-modal-{{ $report->id }}">
                        <div class="space-y-6">
                            <flux:heading size="lg">Weekly Schedule Report Details</flux:heading>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <flux:label>Vessel Name</flux:label>
                                    <p class="text-sm">{{ $report->vessel->name }}</p>
                                </div>
                                <div>
                                    <flux:label>Voyage No</flux:label>
                                    <p class="text-sm">{{ $report->voyage_no }}</p>
                                </div>
                                <div>
                                    <flux:label>Date</flux:label>
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
                                                {{ $port->eta_etb ? \Carbon\Carbon::parse($port->eta_etb)->format('M d, Y h:i A') : '' }}
                                            </p>
                                        </div>
                                        <div>
                                            <flux:label>ETCD</flux:label>
                                            <p class="text-sm">
                                                {{ $port->etcd ? \Carbon\Carbon::parse($port->etcd)->format('M d, Y h:i A') : '' }}
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

                            <div>
                                <flux:label size="sm">Remarks</flux:label>
                                <p class="text-sm">{{ $report->remarks ? $report->remarks->remarks : '' }}</p>
                            </div>

                            <flux:separator />

                            @if ($report->master_info)
                                <div>
                                    <flux:label>Master Information</flux:label>
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

                    <flux:modal name="delete-report-{{ $report->id }}" class="min-w-[22rem]"
                        wire:key="weekly-delete-modal-{{ $report->id }}">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Soft Delete Report?</flux:heading>
                                <flux:text class="mt-2">
                                    Are you sure you want to delete the Weekly Schedule Report? <br> This report will
                                    not be permanently deleted and can be restored if needed.
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
            Showing {{ $reports->firstItem() }} to {{ $reports->lastItem() }} of {{ $reports->total() }}
            results
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
