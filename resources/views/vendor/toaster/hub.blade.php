<div role="status" id="toaster" x-data="toasterHub(@js($toasts), @js($config))"
    @class([ 'fixed z-50 p-4 w-full flex flex-col pointer-events-none sm:p-6' , 'bottom-0'=> $alignment->is('bottom'),
    'top-1/2 -translate-y-1/2' => $alignment->is('middle'),
    'top-0' => $alignment->is('top'),
    'items-start rtl:items-end' => $position->is('left'),
    'items-center' => $position->is('center'),
    'items-end rtl:items-start' => $position->is('right'),
    ])
    >
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.isVisible" x-init="$nextTick(() => toast.show($el))" @if($alignment->is('bottom'))
            x-transition:enter-start="translate-y-8 opacity-0 scale-95"
            x-transition:enter-end="translate-y-0 opacity-100 scale-100"
            @elseif($alignment->is('top'))
            x-transition:enter-start="-translate-y-8 opacity-0 scale-95"
            x-transition:enter-end="translate-y-0 opacity-100 scale-100"
            @else
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            @endif
            x-transition:leave-end="opacity-0 scale-90"
            class="relative transition ease-in-out duration-300 transform pointer-events-auto max-w-sm w-full shadow-xl
            border border-black/10 dark:border-white/10 rounded-2xl px-4 py-3 flex items-center gap-3"
            :class="toast.select({
            error: 'bg-white text-black dark:bg-zinc-900 dark:text-white',
            info: 'bg-white text-black dark:bg-zinc-900 dark:text-white',
            success: 'bg-white text-black dark:bg-zinc-900 dark:text-white',
            warning: 'bg-white text-black dark:bg-zinc-900 dark:text-white'
            })"
            >
            <!-- Icon -->
            <div class="pt-1">
                <svg x-show="toast.type === 'success'" class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <svg x-show="toast.type === 'error'" class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <svg x-show="toast.type === 'warning'" class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 9v2m0 4h.01M12 5C7 5 4 9 4 9s3 4 8 4 8-4 8-4-3-4-8-4z" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <svg x-show="toast.type === 'info'" class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 1010 10A10 10 0 0012 2z" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>

            <!-- Message -->
            <div class="flex-1 text-sm" x-text="toast.message"></div>

            <!-- Close Button -->
            @if($closeable)
            <button @click="toast.dispose()" aria-label="Close"
                class="p-1 rounded-md text-gray-500 hover:text-black dark:hover:text-white transition">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            @endif
        </div>
    </template>
</div>
