<form wire:submit.prevent="save">
    <div class="mb-6 flex items-center justify-between w-full">
        <h1 class="text-3xl font-bold">Crew Monitoring Plan Report</h1>

        <div class="flex items-center gap-3">
            <flux:button icon:trailing="x-mark" variant="danger" wire:click="clearForm">
                Clear Fields
            </flux:button>
            <flux:button href="{{ route('table-crew-monitoring-plan-report') }}" wire:navigate icon:trailing="arrow-uturn-left">
                Go Back
            </flux:button>
            {{-- <flux:button icon="folder-arrow-down">
                Save Draft
            </flux:button>
            <flux:button icon="arrow-down-tray" type="button" wire:click="export">
                Export Data
            </flux:button> --}}
        </div>
    </div>

    <div class="mb-6 flex items-center justify-between w-full">
        <div class="flex items-center gap-3">
            <flux:button wire:click="switchToOnBoard" :variant="$onBoardMode ? 'primary' : 'filled'">On Board Crew
            </flux:button>
            <flux:button wire:click="switchToCrewChange" :variant="!$onBoardMode ? 'primary' : 'filled'">Crew Change
                Data</flux:button>
        </div>

        <flux:button wire:click="{{ $onBoardMode ? 'addBoardRow' : 'addCrewRow' }}">Add Crew</flux:button>
    </div>

    @if ($onBoardMode)
        @foreach ($board_crew as $index => $crew)
            <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
                <flux:fieldset>
                    <flux:legend>
                        Board Crew {{ $index + 1 }}
                    </flux:legend>

                    <div class="space-y-6">
                        <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                            <flux:input label="No" wire:model="board_crew.{{ $index }}.no" />
                            <flux:input label="Vessel Name" badge="Required" disabled
                                wire:model="board_crew.{{ $index }}.vessel_name" />

                            <flux:input label="Crew Surname" required
                                wire:model="board_crew.{{ $index }}.crew_surname" />
                            <flux:input label="Crew First Name" required
                                wire:model="board_crew.{{ $index }}.crew_first_name" />
                            <flux:input label="Rank" required wire:model="board_crew.{{ $index }}.rank" />
                            <flux:input label="Crew Nationality" required
                                wire:model="board_crew.{{ $index }}.crew_nationality" />
                            <flux:input type="datetime-local" label="Joining Date" required
                                wire:model="board_crew.{{ $index }}.joining_date" />
                            <flux:input type="datetime-local" label="Contract Completion Date" required
                                wire:model="board_crew.{{ $index }}.contract_completion" />
                            <flux:input type="datetime-local" label="Current Date" required
                                wire:model="board_crew.{{ $index }}.current_date" />
                            <flux:input label="Date to Contract Completion" required
                                wire:model="board_crew.{{ $index }}.days_contract_completion" />
                            <flux:input label="No of Months On Board" required
                                wire:model="board_crew.{{ $index }}.months_on_board" />
                        </div>
                    </div>

                    <div class="w-full flex items-end justify-end">
                        @if (count($board_crew) > 1)
                            <flux:button variant="danger" wire:click="removeBoardRow({{ $index }})"
                                class="float-right ml-4">
                                Remove Board Crew {{ $index + 1 }}
                            </flux:button>
                        @endif
                    </div>
                </flux:fieldset>
            </div>
        @endforeach
    @else
        @foreach ($crew_change as $index => $crew)
            <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
                <flux:fieldset>
                    <flux:legend>
                        Crew {{ $index + 1 }}
                    </flux:legend>

                    <div class="space-y-6">
                        <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                            <flux:input label="Vessel Name" badge="Required" disabled
                                wire:model="crew_change.{{ $index }}.vessel_name" />

                            <flux:input label="Port" required wire:model="crew_change.{{ $index }}.port" />
                            <flux:input label="Country" required
                                wire:model="crew_change.{{ $index }}.country" />
                            <flux:input type="datetime-local" label="Date of Joiners Boarding" required
                                wire:model="crew_change.{{ $index }}.joiners_boarding" />
                            <flux:input type="datetime-local" label="Date of Off-signers Sign Off" required
                                wire:model="crew_change.{{ $index }}.off_signers" />
                            <flux:input label="Joiners Ranks" required
                                wire:model="crew_change.{{ $index }}.joiner_ranks" />
                            <flux:input label="Off-Signers Ranks" required
                                wire:model="crew_change.{{ $index }}.off_signers_ranks" />
                            <flux:input label="Total Crew Change" required
                                wire:model="crew_change.{{ $index }}.total_crew_change" />
                            <flux:input label="Reason for Change" required
                                wire:model="crew_change.{{ $index }}.reason_change" />
                            <flux:input label="Remarks" required
                                wire:model="crew_change.{{ $index }}.remarks" />
                        </div>
                    </div>

                    <div class="w-full flex items-end justify-end">
                        @if (count($crew_change) > 1)
                            <flux:button variant="danger" wire:click="removeCrewRow({{ $index }})"
                                class="float-right ml-4">
                                Remove Crew {{ $index + 1 }}
                            </flux:button>
                        @endif
                    </div>
                </flux:fieldset>
            </div>
        @endforeach
    @endif

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Master's Info</flux:legend>
            <div class="space-y-6">
                <div class="w-full">
                    <flux:textarea rows="8" wire:model.defer="master_info" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="flex items-center justify-center w-full">
        <flux:button type="submit" icon="check">
            Submit
        </flux:button>
    </div>
</form>
