<div class="idea-and-buttons-container">
    <div class="idea-container bg-white rounded-xl flex mt-4">
        <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
            <div class="flex-none mx-2">
                <a href="#">
                    <img src="{{ $idea->user->avatar }}" alt="" class="w-14 h-14 rounded-xl">
                </a>
            </div>
            <div class="mx-2 mx-4 w-full">
                <h4 class="text-xl font-semibold mt-2 md:mt-0">
                    {{ $idea->title }}
                </h4>
                <div class="text-gray-600 mt-3">
                    @admin
                        @if ($idea->spam_reports > 0)
                            <div class="text-red mb-2">Spam Reports: {{ $idea->spam_reports }}</div>
                        @endif
                    @endadmin
                    {{ $idea->description }}
                </div>

                <div class="flex flex-col md:flex-row md:items-center justify-between mt-6">
                    <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                        <div class="hidden md:block font-semibold text-gray-900">{{ $idea->user->name }}</div>
                        <div class="hidden md:block">&bull;</div>
                        <div>{{ $idea->created_at->diffForHumans() }}</div>
                        <div>&bull;</div>
                        <div>{{ $idea->category->name }}</div>
                        <div>&bull;</div>
                        <div class="text-gray-900">{{ $idea->comments->count() }} comments</div>
                    </div>
                    <div class="flex items-center space-x-2 mt-4 md:mt-0"
                        x-data="{ isOpen: false}">
                        <div class="{{ $idea->status->classes }} text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">{{ $idea->status->name }}</div>
                        @auth
                            <div class="relative">
                                <button class="relative bg-gray-100 hover:bg-gray-200 border transition duration-150 ease-in rounded-full h-7 py-2 px-3"
                                    x-on:click="isOpen = !isOpen">
                                    <svg fill="currentColor" width="24" height="6"><path d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z" style="color: rgba(163, 163, 163, .5)"></svg>
                                </button>
                                <ul class="absolute w-44 font-semibold bg-white shadow-dialog rounded-xl text-left md:ml-8 top-8 md:top-6 right-0 md:left-0 z-10"
                                    x-cloak
                                    x-show="isOpen"
                                    x-transition.top.left
                                    x-on:click.away="isOpen = false"
                                    x-on:keydown.escape.window="isOpen = false">
                                    @can('update', $idea)
                                        <li><a href="#" 
                                            @click.prevent="
                                            $dispatch('custom-show-edit-modal');
                                            isOpen = false;
                                            " 
                                            class="hover:bg-gray-100 hover:rounded-t-xl px-5 py-3 transition duration-150 ease-in block">Edit Idea</a>
                                        </li>
                                    @endcan
                                    @can('delete', $idea)
                                    <li><a href="#" 
                                        @click.prevent="
                                        $dispatch('custom-show-delete-modal');
                                        isOpen = false;
                                        "
                                        class="@cannot('update', $idea) hover:rounded-t-xl @endcannot hover:bg-gray-100 px-5 py-3 transition duration-150 ease-in block">Delete Idea</a>
                                    </li>
                                    @endcan
                                    @if ($idea->spam_reports > 0)
                                        <li><a href="#" 
                                            @click.prevent="
                                            $dispatch('custom-show-mark-as-not-spam-modal');
                                            isOpen = false;
                                            "
                                            class="hover:bg-gray-100 px-5 py-3 transition duration-150 ease-in block">Not Spam</a>
                                        </li>
                                    @endif
                                    <li><a href="#" 
                                        @click.prevent="
                                        $dispatch('custom-show-mark-as-spam-modal');
                                        isOpen = false;
                                        "
                                        class="@cannot('delete', $idea) hover:rounded-t-xl @endcannot hover:bg-gray-100 hover:rounded-b-xl px-5 py-3 transition duration-150 ease-in block">Mark as spam</a>
                                    </li>
                                </ul>
                            </div>
                        @endauth
                    </div>
                    <div class="flex items-center md:hidden mt-4 md:mt-0">
                        <div class="bg-gray-100 text-center rounded-xl h-10 px-4 py-2 pr-8">
                            <div class="text-sm font-bold leading-none @if ($hasVoted) text-blue @endif">{{ $votesCount }}</div>
                            <div class="text-xss font-semibold leading-none text-gray-400">Votes</div>
                        </div>
                        @if ($hasVoted)
                            <button 
                                wire:click.prevent="vote" 
                                class="w-20 text-white bg-blue border boder-blue font-bold text-xxs uppercase rounded-xl hover:bg-blue-hover transition duration-150 ease-in px-4 py-3 -mx-5">
                                Voted
                            </button>
                        @else
                            <button 
                                wire:click.prevent="vote" 
                                class="w-20 bg-gray-200 border boder-gray-200 font-bold text-xxs uppercase rounded-xl hover:border-gray-400 transition duration-150 ease-in px-4 py-3 -mx-5">
                                Vote
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div><!-- fin idea-container -->

    <div class="buttons-container flex items-center justify-between mt-6">
        <div class="flex flex-col md:flex-row items-center space-x-4 md:ml-6">
            <livewire:add-comment :idea="$idea" />
            @admin
                <livewire:set-status :idea="$idea" />
            @endadmin
        </div>

        <div class="hidden md:flex items-center space-x-3">
            <div class="bg-white font-semibold text-center rounded-xl px-3 py-2">
                <div class="text-xl leading-snug @if ($hasVoted) text-blue @endif">{{ $votesCount }}</div>
                <div class="text-gray-400 text-sm leading-none">Votes</div>
            </div>
            @if ($hasVoted)
                <button 
                    type="button" 
                    wire:click.prevent="vote" 
                    class="h-11 w-32 text-white bg-blue font-semibold uppercase rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3">
                    <span>Voted</span>
                </button>
            @else
                <button 
                    type="button" 
                    wire:click.prevent="vote" 
                    class="h-11 w-32 text-xs bg-gray-200 font-semibold uppercase rounded-xl border border-gray-200 hover:bg-gray-400 transition duration-150 ease-in px-6 py-3">
                    <span>Vote</span>
                </button>
            @endif
        </div>
    </div><!-- fin buttons-container -->
</div><!-- fin idea-and-buttons-container -->