<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">Crew Monitoring Plan Reports</h1>

        <div class="flex items-center gap-3">
            <div class="flex gap-2">
                <flux:button :variant="$viewing === 'on-board' ? 'primary' : 'filled'"
                    wire:click="$set('viewing', 'on-board')">
                    On Board Crew
                </flux:button>
                <flux:button :variant="$viewing === 'crew-change' ? 'primary' : 'filled'"
                    wire:click="$set('viewing', 'crew-change')">
                    Crew Change
                </flux:button>
            </div>
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
                <th class="px-3 py-3">Crew Report Type</th>
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
                <td class="px-3 py-4">{{ $report->board_crew->isNotEmpty() ? 'On Board Crew' : 'Crew Change' }}</td>
                <td class="px-3 py-4">
                    {{ \Carbon\Carbon::parse($report->created_at)->timezone('Asia/Manila')->format('M d, Y h:i A') }}
                </td>
                <td class="px-3 py-4">{{ $report->unit->name }}</td>
                <td class="px-3 py-4">
                    <flux:dropdown>
                        <flux:button icon:trailing="ellipsis-horizontal" size="xs" variant="ghost" />

                        <flux:menu>
                            <flux:menu.radio.group>
                                @if ($report->board_crew->isNotEmpty())
                                    <flux:modal.trigger name="view-onboard-{{ $report->id }}">
                                        <flux:menu.item icon="eye">
                                            View Details (On Board)
                                        </flux:menu.item>
                                    </flux:modal.trigger>
                                @elseif ($report->crew_change->isNotEmpty())
                                    <flux:modal.trigger name="view-crewchange-{{ $report->id }}">
                                        <flux:menu.item icon="eye">
                                            View Details (Crew Change)
                                        </flux:menu.item>
                                    </flux:modal.trigger>
                                @endif
                                <flux:modal.trigger name="delete-report-{{ $report->id }}">
                                    <flux:menu.item icon="trash" variant="danger">
                                        Delete
                                    </flux:menu.item>
                                </flux:modal.trigger>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>

                    @if ($report->board_crew->isNotEmpty())
                        <flux:modal name="view-onboard-{{ $report->id }}" class="min-w-[28rem] md:w-[48rem]">
                            <div class="space-y-6">
                                <flux:heading size="lg">On Board Crew</flux:heading>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <flux:label>Vessel</flux:label>
                                        <p class="text-sm">{{ $report->vessel->name }}</p>
                                    </div>
                                </div>

                                <flux:separator />

                                <div class="grid grid-cols-2 gap-4">
                                    @foreach ($report->board_crew as $i => $crew)
                                        <div class="col-span-2">
                                            <flux:heading size="lg">Board Crew {{ $i + 1 }}</flux:heading>
                                        </div>
                                        <div>
                                            <flux:label>No</flux:label>
                                            <p class="text-sm">{{ $crew->no }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Crew Surname</flux:label>
                                            <p class="text-sm">{{ $crew->crew_surname }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Crew First Name</flux:label>
                                            <p class="text-sm">{{ $crew->crew_first_name }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Rank</flux:label>
                                            <p class="text-sm">{{ $crew->rank }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Crew Nationality</flux:label>
                                            <p class="text-sm">{{ $crew->crew_nationality }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Joining Date</flux:label>
                                            <p class="text-sm">
                                                {{ $crew->joining_date ? \Carbon\Carbon::parse($crew->joining_date)->format('M d, Y h:i A') : '' }}
                                            </p>
                                        </div>
                                        <div>
                                            <flux:label>Contract Completion</flux:label>
                                            <p class="text-sm">
                                                {{ $crew->contract_completion ? \Carbon\Carbon::parse($crew->contract_completion)->format('M d, Y h:i A') : '' }}
                                            </p>
                                        </div>
                                        <div>
                                            <flux:label>Current Date</flux:label>
                                            <p class="text-sm">
                                                {{ $crew->current_date ? \Carbon\Carbon::parse($crew->current_date)->format('M d, Y h:i A') : '' }}
                                            </p>
                                        </div>
                                        <div>
                                            <flux:label>Days to Completion</flux:label>
                                            <p class="text-sm">{{ $crew->days_contract_completion }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Months On Board</flux:label>
                                            <p class="text-sm">{{ $crew->months_on_board }}</p>
                                        </div>
                                        <div class="col-span-2">
                                            <flux:separator />
                                        </div>
                                    @endforeach
                                </div>

                                <div>
                                    <flux:label size="sm">Remarks</flux:label>
                                    <p class="text-sm">{{ $report->remarks?->remarks }}</p>
                                </div>
                                <flux:separator />
                                <div>
                                    <flux:label>Master Information</flux:label>
                                    <p class="text-sm">{{ $report->master_info?->master_info }}</p>
                                </div>

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
                                        Are you sure you want to delete the Crew Monitoring Plan Report? <br> This
                                        report will not be permanently deleted and can be restored if needed.
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
                    @endif

                    @if ($report->crew_change->isNotEmpty())
                        <flux:modal name="view-crewchange-{{ $report->id }}" class="min-w-[28rem] md:w-[48rem]">
                            <div class="space-y-6">
                                <flux:heading size="lg">Crew Change</flux:heading>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <flux:label>Vessel</flux:label>
                                        <p class="text-sm">{{ $report->vessel->name }}</p>
                                    </div>
                                </div>

                                <flux:separator />

                                <div class="grid grid-cols-2 gap-4">
                                    @foreach ($report->crew_change as $i => $crew)
                                        <div class="col-span-2">
                                            <flux:heading size="lg">Crew Change {{ $i + 1 }}</flux:heading>
                                        </div>
                                        <div>
                                            <flux:label>Port</flux:label>
                                            <p class="text-sm">{{ $crew->port }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Country</flux:label>
                                            <p class="text-sm">{{ $crew->country }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Date of Joiners Boarding</flux:label>
                                            <p class="text-sm">
                                                {{ $crew->joiners_boarding ? \Carbon\Carbon::parse($crew->joiners_boarding)->format('M d, Y h:i A') : '' }}
                                            </p>
                                        </div>
                                        <div>
                                            <flux:label>Date of Off-signers Sign Off</flux:label>
                                            <p class="text-sm">
                                                {{ $crew->off_signers ? \Carbon\Carbon::parse($crew->off_signers)->format('M d, Y h:i A') : '' }}
                                            </p>
                                        </div>
                                        <div>
                                            <flux:label>Joiners Ranks</flux:label>
                                            <p class="text-sm">{{ $crew->joiner_ranks }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Off-Signers Ranks</flux:label>
                                            <p class="text-sm">{{ $crew->off_signers_ranks }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Total Crew Change</flux:label>
                                            <p class="text-sm">{{ $crew->total_crew_change }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Reason for Change</flux:label>
                                            <p class="text-sm">{{ $crew->reason_change }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Remarks</flux:label>
                                            <p class="text-sm">{{ $crew->remarks }}</p>
                                        </div>
                                        <div class="col-span-2">
                                            <flux:separator />
                                        </div>
                                    @endforeach
                                </div>

                                <div>
                                    <flux:label size="sm">Remarks</flux:label>
                                    <p class="text-sm">{{ $report->remarks?->remarks }}</p>
                                </div>
                                <flux:separator />
                                <div>
                                    <flux:label>Master Information</flux:label>
                                    <p class="text-sm">{{ $report->master_info?->master_info }}</p>
                                </div>

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
                                        Are you sure you want to delete the Crew Monitoring Plan Report? <br> This
                                        report will not be permanently deleted and can be restored if needed.
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
                    @endif
                </td>
            </tr>
        @endforeach
    </x-admin-components.table>


    <div class="mt-6">
        {{ $reports->links() }}
    </div>
</div>
