<div>
    <flux:input wire:model.live.debounce.150ms="query" placeholder="Search pages..." class="w-full"
        autofocus />

    @if (count($results) > 0)
        @foreach ($results as $result)
            <div class="flex flex-col gap-3 mt-3">
                <flux:link class="cursor-pointer" wire:navigate href="{{ $result['url'] }}">{{ $result['name'] }}</flux:link>
            </div>
        @endforeach
    @elseif(strlen($query) > 0)
        <flux:heading class="mt-3 text-center">No results found.</flux:heading>
    @endif
</div>
