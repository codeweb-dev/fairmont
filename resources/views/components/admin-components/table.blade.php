<div class="overflow-x-auto rounded-lg border dark:border-white/10 border-black/10">
    <table class="min-w-full text-sm text-left">
        <thead class="border-b dark:border-white/10 border-black/10 hover:bg-white/5 bg-black/5 transition-all">
            <tr>
                @foreach ($headers as $header)
                <th class="px-3 py-3">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
