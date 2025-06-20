<div class="w-full gap-4 min-h-10/12 flex items-center justify-center flex-col">
    <div class="flex items-center justify-center flex-col">
        <flux:heading size="lg">You are not assigned to a vessel.</flux:heading>
        <flux:text class="mt-1">Please contact your administrator.</flux:text>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <flux:button type="submit" icon="arrow-right-start-on-rectangle">
            {{ __('Log Out') }}
        </flux:button>
    </form>
</div>
