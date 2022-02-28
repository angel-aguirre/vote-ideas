<div class="relative" x-data="{ isOpen: false }"
    x-init="
        window.livewire.on('statusWasUpdated', () => {
            isOpen = false;
        })
    ">
    <button type="button" class="flex items-center justify-center h-11 w-36 text-sm bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:bg-gray-400 transition duration-150 ease-in px-6 py-3 mt-2 md:mt-0"
        x-on:click="isOpen = !isOpen">
        <span>Set Status</span>
        <svg class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    <div class="absolute z-20 w-65 md:w-76 text-left font-semibold text-sm bg-white shadow-dialog rounded-xl mt-2"
        x-cloak
        x-show="isOpen"
        x-transition.top
        x-on:click.away="isOpen = false"
        x-on:keydown.escape.window="isOpen = false">
        <form wire:submit.prevent="setStatus" action="#"" class="space-y-4 px-4 py-6">
            <div class="space-y-2">
                <div>
                    <label class="inline-flex items-center">
                        <input wire:model="status" type="radio" checked="" name="status" value="1"
                            class="bg-gray-200 text-black border-none">
                        <span class="ml-2 select-none">Open</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input wire:model="status" type="radio" name="status" value="2"
                            class="bg-gray-200 text-purple border-none">
                        <span class="ml-2 select-none">Considering</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input wire:model="status" type="radio" name="status" value="3"
                            class="bg-gray-200 text-yellow border-none">
                        <span class="ml-2 select-none">In Progress</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input wire:model="status" type="radio" name="status" value="4"
                            class="bg-gray-200 text-green border-none">
                        <span class="ml-2 select-none">Implemented</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input wire:model="status" type="radio" name="status" value="5"
                            class="bg-gray-200 text-red border-none">
                        <span class="ml-2 select-none">Closed</span>
                    </label>
                </div>
            </div><!-- fin radio-buttons -->
            <div>
                <textarea wire:model="comment"
                    name="update_comment" id="update_comment" cols="30" rows="3"
                    class="w-full text-sm bg-gray-100 rounded-xl placeholder-gray-900 border-none px-4 py-2"
                    placeholder="Add an update comment (optional)"></textarea>
            </div><!-- fin textarea -->
            <div class="flex items-center justify-between space-x-3">
                <button type="button" class="flex items-center justify-center w-1/2 h-11 text-xs bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3">
                    <svg class="text-gray-600 w-4 transform -rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                    </svg>
                    <span class="ml-1">Attach</span>
                </button>
                <button type="submit" class="flex items-center justify-center w-1/2 h-11 text-xs bg-blue text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3 disabled:opacity-50">
                    <span class="ml-1">Update</span>
                </button>
            </div><!-- fin buttons -->
            <div>
                <label class="font-normal inline-flex items-center">
                    <input wire:model="notifyAllVoters" type="checkbox" name="notify_voters" 
                        class="rounded bg-gray-200">
                    <span class="ml-2 select-none select-none">Notify all voters</span>
                </label>
            </div>
        </form>
    </div>
</div>