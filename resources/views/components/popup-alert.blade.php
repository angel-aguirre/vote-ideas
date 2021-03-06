<div 
    x-cloak
    x-data="{ 
        isOpen: false,
        isError: @if ($type == 'error') true @elseif ($type == 'success') false @endif,
        messageToDisplay: '{{ $message }}',
        showNotification(message) {
            this.isOpen = true;
            this.messageToDisplay = message;
            setTimeout(() => { this.isOpen = false }, 5000);
        },
    }"
    x-show="isOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-x-8"
    x-transition:enter-end="opacity-100 transform translate-x-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 transform translate-x-0"
    x-transition:leave-end="opacity-0 transform translate-x-8"
    x-init="
        @if ($showOnPageLoad)
            $nextTick(() => showNotification(messageToDisplay));
        @else
            Livewire.on('openNotification', (detail) => {
                if (detail.type == 'success') isError = false;
                else if (detail.type == 'error') isError = true;

                showNotification(detail.message) 
            });
        @endif
    "
    class="z-10 flex justify-between max-w-xw sm:max-w-sm sm:w-full w-70 fixed bottom-0 right-0 bg-white rounded-xl shadow-lg border px-6 py-5 mx-2 sm:mx-6 my-8">
    <div class="flex items-center">
        <svg 
            x-show="!isError"
            class="text-green h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>

        <svg 
            x-show="isError"
            class="text-red h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>

        <div class="font-semibold text-gray-500 text-sm sm:text-base ml-2" x-text="messageToDisplay"></div>
    </div>
    <button 
        @click="
            isOpen = false
        "
        class="text-gray-400 hover:text-gray-500">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>