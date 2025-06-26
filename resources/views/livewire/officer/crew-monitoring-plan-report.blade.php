<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">
            Crew Monitoring Plan Reports
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

            @if (count($selectedReports) > 0)
                <div>
                    <flux:button wire:click="exportSelected" icon:trailing="inbox-arrow-down" variant="filled">
                        Export Selected ({{ count($selectedReports) }})
                    </flux:button>
                </div>
            @endif

            <div>
                <flux:button href="{{ route('crew-monitoring-plan') }}" wire:navigate icon:trailing="plus">
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
                <th class="px-3 py-3"></th>
            </tr>
        </thead>

        @foreach ($reports as $report)
            <tr class="hover:bg-white/5 bg-black/5 transition-all">
                <td class="px-3 py-4">
                    <flux:checkbox wire:model.live="selectedReports" value="{{ $report->id }}" />
                </td>
                <td class="px-3 py-4">{{ $report->report_type }}</td>
                <td class="px-3 py-4">{{ $report->vessel->name }}</td>
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
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>

                    <flux:modal name="view-report-{{ $report->id }}" class="min-w-[28rem] md:w-[48rem]">
                        <div class="space-y-6">
                            <flux:heading size="lg">Crew Monitoring Plan Report Details</flux:heading>

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
                                    <flux:label>Master's Info</flux:label>
                                    <p class="text-sm">
                                        {{ $report->master_info ? $report->master_info->master_info : 'No information available' }}
                                    </p>
                                </div>
                            </div>

                            <flux:separator />

                            <div class="pt-4">
                                <div class="space-y-6">
                                    @if ($report->board_crew->isNotEmpty())
                                        <div class="pt-4">
                                            <flux:heading size="lg">Board Crew Details</flux:heading>
                                            <div class="space-y-4">
                                                @foreach ($report->board_crew as $crew)
                                                    <div class="mt-6">
                                                        <p class="mb-3"><strong>First Name:</strong>
                                                            {{ $crew->crew_first_name }}</p>
                                                        <p class="mb-3"><strong>Surname:</strong>
                                                            {{ $crew->crew_surname }}</p>
                                                        <p class="mb-3"><strong>Rank:</strong> {{ $crew->rank }}
                                                        </p>
                                                        <p class="mb-3"><strong>Joining Date:</strong>
                                                            {{ \Carbon\Carbon::parse($crew->joining_date)->format('M d, Y h:i A') }}
                                                        </p>
                                                        <p class="mb-3"><strong>Contract Completion:</strong>
                                                            {{ \Carbon\Carbon::parse($crew->contract_completion)->format('M d, Y h:i A') }}
                                                        </p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if ($report->crew_change->isNotEmpty())
                                        <div class="pt-4">
                                            <flux:heading size="lg">Crew Change Details</flux:heading>
                                            <div class="space-y-4">
                                                @foreach ($report->crew_change as $crew)
                                                    <div class="mt-6">
                                                        <p class="mb-3"><strong>Port:</strong> {{ $crew->port }}
                                                        </p>
                                                        <p class="mb-3"><strong>Country:</strong>
                                                            {{ $crew->country }}</p>
                                                        <p class="mb-3"><strong>Joiners Boarding:</strong>
                                                            {{ \Carbon\Carbon::parse($crew->joiners_boarding)->format('M d, Y h:i A') }}
                                                        </p>
                                                        <p class="mb-3"><strong>Off-signers:</strong>
                                                            {{ \Carbon\Carbon::parse($crew->off_signers)->format('M d, Y h:i A') }}
                                                        </p>
                                                        <p class="mb-3"><strong>Joiner Ranks:</strong>
                                                            {{ $crew->joiner_ranks }}</p>
                                                        <p class="mb-3"><strong>Off-Signer Ranks:</strong>
                                                            {{ $crew->off_signer_ranks }}</p>
                                                        <p class="mb-3"><strong>Total Crew Change:</strong>
                                                            {{ $crew->total_crew_change }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

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
