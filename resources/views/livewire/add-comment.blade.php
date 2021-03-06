<div class="relative" x-data="{ isOpen: false }">
    <button type="button" class="h-11 w-32 text-sm bg-blue text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3"
        x-on:click="
            isOpen = !isOpen;
            if(isOpen) $nextTick(() => $refs.comment.focus());
        ">
        Reply
    </button>
    <div class="absolute z-10 w-64 md:w-104 text-left font-semibold text-sm bg-white shadow-dialog rounded-xl mt-2"
        x-cloak 
        x-show="isOpen"
        x-init="
            Livewire.on('commentWasAdded', function() {
                isOpen = false;
            });

            @if (session('scrollToComment'))
                $nextTick(() => {
                    console.log('{{ session('scrollToComment') }}');
                    const commentToScrollTo = document.querySelector('#comment-{{ session('scrollToComment') }}')
                    commentToScrollTo.scrollIntoView({ behavior: 'smooth'})
                    commentToScrollTo.classList.add('bg-green-50')
                    setTimeout(() => {
                        commentToScrollTo.classList.remove('bg-green-50')
                    }, 5000)
                });
            @endif
        "
        x-transition.top
        x-on:click.away="isOpen = false"
        x-on:keydown.escape.window="isOpen = false"
        x-on:comment-was-added.window="
            comments = document.querySelectorAll('.comment-container');
            lastComment = comments[comments.length - 1];
            lastComment.scrollIntoView({ behavior: 'smooth' });
            lastComment.classList.add('bg-green-50');
            setTimeout(() => lastComment.classList.remove('bg-green-50'), 5000);
        "
        >
        @auth
            <form wire:submit.prevent="addComment" action="#" class="space-y-4 px-4 py-6">
                <div>
                    <textarea
                        wire:model="comment"
                        x-ref="comment"
                        name="post_comment" id="post_comment" cols="30" rows="4"
                        class="w-full text-sm bg-gray-100 rounded-xl placeholder-gray-900 border-none px-4 py-2"
                        placeholder="Go ahead, don't be shy. Share your thoughts..."></textarea>
                    @error('comment')
                        <p class="text-red text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col md:flex-row items-center md:space-x-3">
                    <button type="submit" class="flex items-center justify-center h-11 w-full md:w-1/2 text-sm bg-blue text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3">
                        Post Comment
                    </button>
                    <button type="button" class="flex items-center justify-center w-full md:w-32 h-11 text-xs bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3 mt-2 md:mt-0">
                        <svg class="text-gray-600 w-4 transform -rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        <span class="ml-1">Attach</span>
                    </button>
                </div>
            </form>
        @else
            <div class="px-4 py-6">
                <p class="font-normal">Please login or create an account to post a comment.</p>
                <div class="flex items-center text-center space-x-3 mt-8">
                    <a 
                        wire:click.prevent="redirectToRegister"
                        href="{{ route('register') }}" 
                        class="inline-block w-1/2 h-11 text-xs bg-blue text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3"
                    >
                        Register
                    </a>
                    <a 
                        wire:click.prevent="redirectToLogin"
                        href="{{ route('login') }}" 
                        class="inline-block w-1/2 h-11 text-xs bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3"
                    >
                        Login
                    </a>
                </div>
            </div>
        @endauth
    </div>
</div>