<div>
    <div class="mb-6 flex items-center justify-between w-full">
        <flux:heading size="xl" class="font-bold">Crew Monitoring Plan</flux:heading>

        <div class="flex items-center gap-3">
            <flux:button icon:trailing="x-mark" variant="danger">Clear Fields</flux:button>
            <flux:button icon="folder-arrow-down">Save Draft</flux:button>
            <flux:button icon="arrow-down-tray">Export Data</flux:button>
        </div>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Voyage Details</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-3 gap-x-4 gap-y-6">
                    <flux:select label="Vessel Name" badge="Required" required>
                        <option selected>Select Vessel</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="Voyage No" badge="Required" required />
                    <flux:input label="All Fast Date/Time (LT)" type="date" max="2999-12-31" badge="Required"
                        required />
                    <flux:select label="GMT Offset" badge="Required" required>
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="Port" badge="Required" required />
                </div>
            </div>
        </flux:fieldset>
    </div>
</div>
