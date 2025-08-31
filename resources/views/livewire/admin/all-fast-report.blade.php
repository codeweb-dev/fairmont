<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">All Fast Reports</h1>

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
            <tr class="hover:bg-white/5 bg-black/5 transition-all">
                <td class="px-3 py-4">{{ $report->report_type ?? '' }}</td>
                <td class="px-3 py-4">{{ $report->vessel->name ?? '' }}</td>
                <td class="px-3 py-4">{{ $report->voyage_no ?? '' }}</td>
                <td class="px-3 py-4">
                    {{ \Carbon\Carbon::parse($report->created_at)->timezone('Asia/Manila')->format('M d, Y h:i A') ?? '' }}
                </td>
                <td class="px-3 py-4">{{ $report->unit->name ?? '' }}</td>
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
                                    <flux:label>Vessel Name</flux:label>
                                    <p class="text-sm">{{ $report->vessel->name }}</p>
                                </div>
                                <div>
                                    <flux:label>Voyage No</flux:label>
                                    <p class="text-sm">{{ $report->voyage_no }}</p>
                                </div>
                                <div>
                                    <flux:label>All Fast Date/Time (LT)</flux:label>
                                    <p class="text-sm">
                                        {{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                                <div>
                                    <flux:label>GMT Offset</flux:label>
                                    <p class="text-sm">{{ $report->gmt_offset }}</p>
                                </div>
                                <div>
                                    <flux:label>Port</flux:label>
                                    <p class="text-sm">{{ $report->port }}</p>
                                </div>
                            </div>

                            <flux:separator />

                            <div>
                                <flux:label>ROB Entries</flux:label>
                                <div class="overflow-x-auto mt-3">
                                    <table
                                        class="min-w-full text-sm border-collapse border border-zinc-200 dark:border-zinc-700">
                                        <thead>
                                            <tr>
                                                <th class="p-2 border border-zinc-200 dark:border-zinc-700">HSFO</th>
                                                <th class="p-2 border border-zinc-200 dark:border-zinc-700">BIO</th>
                                                <th class="p-2 border border-zinc-200 dark:border-zinc-700">VLSFO</th>
                                                <th class="p-2 border border-zinc-200 dark:border-zinc-700">LSMGO</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-zinc-100 dark:divide-white/5">
                                            @foreach ($report->robs as $rob)
                                                <tr>
                                                    <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $rob->hsfo !== null ? rtrim(rtrim(number_format((float) $rob->hsfo, 3, '.', ''), '0'), '.') : '' }}
                                                    </td>
                                                    <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $rob->biofuel !== null ? rtrim(rtrim(number_format((float) $rob->biofuel, 3, '.', ''), '0'), '.') : '' }}
                                                    </td>
                                                    <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $rob->vlsfo !== null ? rtrim(rtrim(number_format((float) $rob->vlsfo, 3, '.', ''), '0'), '.') : '' }}
                                                    </td>
                                                    <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $rob->lsmgo !== null ? rtrim(rtrim(number_format((float) $rob->lsmgo, 3, '.', ''), '0'), '.') : '' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <flux:separator />

                            <div>
                                <flux:label size="sm">Remarks</flux:label>
                                <p class="text-sm">{{ $report->remarks ? $report->remarks->remarks : '' }}</p>
                            </div>

                            <flux:separator />

                            <div>
                                <flux:label>Master Information</flux:label>
                                <p class="text-sm whitespace-pre-line">
                                    {{ $report->master_info ? $report->master_info->master_info : '' }}</p>
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
                                    Are you sure you want to delete the All Fast Report? <br> This report will not be permanently deleted and can be restored if needed.
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
