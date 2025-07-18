<form wire:submit.prevent="save">
    <div class="mb-6 flex items-center justify-between w-full">
        <h1 class="text-3xl font-bold">Crew Monitoring Plan Report</h1>

        <div class="flex items-center gap-3">
            <flux:button icon:trailing="x-mark" variant="danger" wire:click="clearForm"
                @click="Toaster.success('Fields cleared successfully.')">
                Clear Fields
            </flux:button>
            <flux:button icon="folder-arrow-down" wire:click="saveDraft" variant="outline"
                @click="Toaster.success('Draft saved successfully.')">
                Save Draft
            </flux:button>
            <flux:button href="{{ route('table-crew-monitoring-plan-report') }}" wire:navigate
                icon:trailing="arrow-uturn-left">
                Go Back
            </flux:button>
        </div>
    </div>

    <div class="mb-6 flex items-center justify-between w-full">
        <div class="flex items-center gap-3">
            <flux:button wire:click="switchToOnBoard" :variant="$onBoardMode ? 'primary' : 'filled'">On Board Crew
            </flux:button>
            <flux:button wire:click="switchToCrewChange" :variant="!$onBoardMode ? 'primary' : 'filled'">Crew Change</flux:button>
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
                            <flux:input label="Vessel Name" wire:model="board_crew.{{ $index }}.vessel_name" disabled />

                            <flux:input label="Crew Surname" wire:model="board_crew.{{ $index }}.crew_surname" />
                            <flux:input label="Crew First Name" wire:model="board_crew.{{ $index }}.crew_first_name" />
                            <flux:input label="Rank" wire:model="board_crew.{{ $index }}.rank" />
                            <flux:input label="Crew Nationality" wire:model="board_crew.{{ $index }}.crew_nationality" />
                            <flux:input type="datetime-local" label="Joining Date" wire:model="board_crew.{{ $index }}.joining_date" />
                            <flux:input type="datetime-local" label="Contract Complete Date" wire:model="board_crew.{{ $index }}.contract_completion" />
                            <flux:input type="datetime-local" label="Current Date" wire:model="board_crew.{{ $index }}.current_date" />
                            <flux:input label="Date to Contract Completion" wire:model="board_crew.{{ $index }}.days_contract_completion" />
                            <flux:input label="No of Months On Board" wire:model="board_crew.{{ $index }}.months_on_board" />
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
                            <flux:input label="Vessel Name" disabled wire:model="crew_change.{{ $index }}.vessel_name" />

                            <flux:input label="Port" wire:model="crew_change.{{ $index }}.port" />
                            <flux:input label="Country" wire:model="crew_change.{{ $index }}.country" />
                            <flux:input type="datetime-local" label="Date of Joiners Boarding" wire:model="crew_change.{{ $index }}.joiners_boarding" />
                            <flux:input type="datetime-local" label="Date of Off-signers Sign Off" wire:model="crew_change.{{ $index }}.off_signers" />
                            <flux:input label="Joiners Ranks" wire:model="crew_change.{{ $index }}.joiner_ranks" />
                            <flux:input label="Off-Signers Ranks" wire:model="crew_change.{{ $index }}.off_signers_ranks" />
                            <flux:input label="Total Crew Change" wire:model="crew_change.{{ $index }}.total_crew_change" />
                            <flux:input label="Reason for Change" wire:model="crew_change.{{ $index }}.reason_change" />
                            <flux:input label="Remarks" wire:model="crew_change.{{ $index }}.remarks" />
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
            <flux:legend>Remarks</flux:legend>
            <div class="space-y-6">
                <div class="w-full">
                    <flux:textarea rows="8" wire:model.defer="remarks" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Master Information <flux:badge size="sm">Required</flux:badge>
            </flux:legend>
            <div class="space-y-6">
                <div class="w-full">
                    <flux:textarea rows="8" wire:model.defer="master_info" required />
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
