<div class="
    @if ($comment->is_status_update) is-status-update {{ 'status-'.Str::kebab($comment->status->name) }} @endif
    comment-container relative bg-white rounded-xl flex mt-4 transition duration-150 ease-in"
>
    <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
        <div class="flex-none">
            <a href="#">
                <img src="{{ $comment->user->avatar }}" alt="" class="w-14 h-14 rounded-xl">
            </a>
            @if ($comment->user->isAdmin())
                <div class="text-center uppercase text-blue text-xxs font-bold mt-1">Admin</div>
            @endif
        </div>
        <div class="md:mx-4 w-full">
            <div class="text-gray-600">
                @admin
                    @if ($comment->spam_reports > 0)
                        <div class="text-red mb-2">Spam Reports: {{ $comment->spam_reports }}</div>
                    @endif
                @endadmin
                @if ($comment->is_status_update)
                    <h4 class="text-xl font-semibold mb-3">
                        Status Changed to "{{ $comment->status->name }}"
                    </h4>
                @endif
                <div>{{ $comment->body }}</div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                    <div class="
                        @if ($comment->is_status_update) text-blue @endif font-bold text-gray-900"
                    >{{ $comment->user->name }}</div>
                    <div>&bull;</div>
                    @if ($comment->user->id === $ideaUserId)
                        <div class="rounded-full border bg-gray-100 px-3 py-1">OP</div>
                        <div>&bull;</div>
                    @endif
                    <div>{{ $comment->created_at->diffForHumans() }}</div>
                </div>
                @auth
                    <div class="flex items-center space-x-2"
                        x-data="{ isOpen: false }">
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
                                @can('update', $comment)
                                    <li><a href="#" 
                                        @click.prevent="
                                        isOpen = false;
                                        Livewire.emit('setEditComment', {{ $comment->id }})
                                        " 
                                        class="hover:bg-gray-100 hover:rounded-t-xl px-5 py-3 transition duration-150 ease-in block">Edit Comment</a>
                                    </li>
                                @endcan
                                @can('delete', $comment)
                                    <li><a href="#" 
                                        @click.prevent="
                                        isOpen = false;
                                        Livewire.emit('setDeleteComment', {{ $comment->id }})
                                        " 
                                        class="
                                            @cannot('update', $comment) hover:rounder-t-xl @endcannot
                                            hover:bg-gray-100 px-5 py-3 transition duration-150 ease-in block"
                                        >Delete Comment</a>
                                    </li>
                                @endcan
                                @admin
                                    @if ($comment->spam_reports > 0)
                                        <li>
                                            <a
                                                href="#"
                                                @click.prevent="
                                                    isOpen = false
                                                    Livewire.emit('setMarkAsNotSpamComment', {{ $comment->id }})
                                                "
                                                class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3"
                                            >
                                                Not Spam
                                            </a>
                                        </li>
                                    @endif
                                @endadmin
                                <li>
                                    <a href="#" 
                                        @click.prevent="
                                        isOpen = false;
                                        Livewire.emit('setMarkAsSpamComment', {{ $comment->id }})
                                        "
                                        class="
                                        @cannot('delete', $comment) hover:rounded-t-xl @endcannot 
                                        hover:rounded-b-xl hover:bg-gray-100 px-5 py-3 transition duration-150 ease-in block"
                                    >
                                        Mark as spam</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div><!-- fin comment-container -->