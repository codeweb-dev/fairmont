<div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
    <flux:fieldset>
        <flux:legend>Noon Conditions</flux:legend>
        <div class="space-y-6">
            <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                <flux:select label="Condition" badge="Required" placeholder="Select Condition" required>
                    <flux:select.option>Ballast</flux:select.option>
                    <flux:select.option>Laden</flux:select.option>
                </flux:select>
                <flux:input label="Displacement (MT)" />
                <flux:input label="Cargo Name" />
                <flux:input label="Cargo Weight (MT)" />

                <flux:input label="Ballast Weight (MT)" />
                <flux:input label="Fresh Water (MT)" />
                <flux:input label="Fwd Draft (m)" />
                <flux:input label="Aft Draft (m)" />

                <flux:input label="GM" class="w-full" />
            </div>
        </div>
    </flux:fieldset>
</div>
