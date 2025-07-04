<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">
            All Fast Reports
        </h1>

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

    <x-admin-components.table>
        <thead class="border-b dark:border-white/10 border-black/10 hover:bg-white/5 bg-black/5 transition-all">
            <tr>
                <th class="px-3 py-3">Report Type</th>
                <th class="px-3 py-3">Vessel</th>
                <th class="px-3 py-3">Unit</th>
                <th class="px-3 py-3">Voyage No</th>
                <th class="px-3 py-3">Port</th>
                <th class="px-3 py-3">Date</th>
                <th class="px-3 py-3"></th>
            </tr>
        </thead>

        @foreach ($reports as $report)
            <tr class="hover:bg-white/5 bg-black/5 transition-all">
                <td class="px-3 py-4">{{ $report->report_type }}</td>
                <td class="px-3 py-4">{{ $report->vessel->name }}</td>
                <td class="px-3 py-4">{{ $report->unit->name }}</td>
                <td class="px-3 py-4">{{ $report->voyage_no }}</td>
                <td class="px-3 py-4">{{ $report->port }}</td>
                <td class="px-3 py-4">{{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') }}
                </td>
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

                    <flux:modal name="view-report-{{ $report->id }}" class="min-w-[28rem] md:w-[38rem]">
                        <div class="space-y-6">
                            <flux:heading size="lg">Report Details</flux:heading>
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
                                    <flux:label>Port</flux:label>
                                    <p class="text-sm">{{ $report->port }}</p>
                                </div>
                                <div>
                                    <flux:label>Date</flux:label>
                                    <p class="text-sm">
                                        {{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>

                            <div>
                                <flux:label>ROB Entries</flux:label>
                                <div class="grid grid-cols-4">
                                    @foreach ($report->robs as $rob)
                                        <p>HSFO : {{ $rob->hsfo ?? 'N/A' }}</p>
                                        <p>BIO : {{ $rob->biofuel ?? 'N/A' }}</p>
                                        <p>VLSFO : {{ $rob->vlsfo ?? 'N/A' }}</p>
                                        <p>LSMGO : {{ $rob->lsmgo ?? 'N/A' }}</p>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex justify-end">
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
                                    Are you sure you want to delete the All Fast Report for
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

    <div class="mt-6">
        {{ $reports->links() }}
    </div>
</div>
