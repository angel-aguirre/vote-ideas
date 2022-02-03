<x-app-layout>
    <div>
        <a href="{{ url()->previous() }}" class="flex items-center font-semibold hover:underline">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="ml-2 select-none">All ideas (or back to chosen category with filters)</span>
        </a>
    </div>

    <livewire:idea-show 
        :idea="$idea"
        :votesCount="$votesCount" />

    <div class="comments-container relative space-y-6 md:ml-22 pt-4 my-8 mt-1">
        <div class="comment-container relative bg-white rounded-xl flex mt-4">
            <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
                <div class="flex-none">
                    <a href="#">
                        <img src="https://source.unsplash.com/200x200/?face&crop=face&v=2" alt="" class="w-14 h-14 rounded-xl">
                    </a>
                </div>
                <div class="md:mx-4">
                    <div class="text-gray-600 mt-3">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi doloribus saepe incidunt vitae repudiandae recusandae quae mollitia nihil aperiam similique.
                    </div>
    
                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                            <div class="font-bold text-gray-900">John Doe</div>
                            <div>&bull;</div>
                            <div>10 hours ago</div>
                        </div>
                        <div class="flex items-center space-x-2"
                            x-data="{ isOpen: false }">
                            <button class="relative bg-gray-100 hover:bg-gray-200 border transition duration-150 ease-in rounded-full h-7 py-2 px-3"
                                x-on:click="isOpen = !isOpen">
                                <svg fill="currentColor" width="24" height="6"><path d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z" style="color: rgba(163, 163, 163, .5)"></svg>
                                <ul class="absolute w-44 font-semibold bg-white shadow-dialog rounded-xl text-left md:ml-8 top-8 md:top-6 right-0 md:left-0 z-10"
                                    x-cloak
                                    x-show="isOpen"
                                    x-transition.top.left
                                    x-on:click.away="isOpen = false"
                                    x-on:keydown.escape.window="isOpen = false">
                                    <li><a href="#" class="hover:bg-gray-100 hover:rounded-t-xl px-5 py-3 transition duration-150 ease-in block">Mark as spam</a></li>
                                    <li><a href="#" class="hover:bg-gray-100 hover:rounded-b-xl px-5 py-3 transition duration-150 ease-in block">Delete Post</a></li>
                                </ul>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- fin comment-container -->
        <div class="is-admin comment-container relative bg-white rounded-xl flex mt-4">
            <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
                <div class="flex-none">
                    <a href="#">
                        <img src="https://source.unsplash.com/200x200/?face&crop=face&v=3" alt="" class="w-14 h-14 rounded-xl">
                    </a>
                    <div class="text-center uppercase text-blue text-xxs font-bold mt-1">
                        Admin
                    </div>
                </div>
                <div class="md:mx-4">
                    <h4 class="text-xl font-semibold">
                        <a href="#" class="hover:underline">Status Changed to "Under Construction"</a>
                    </h4>
                    <div class="text-gray-600 mt-3">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur error similique commodi incidunt deleniti quos excepturi rem saepe repellat quam sed, sapiente, eaque vero mollitia modi! Officia, accusantium quisquam odit cumque tempore blanditiis accusamus nobis repellat, voluptatibus eos magnam neque.
                    </div>
    
                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                            <div class="font-bold text-blue">Andrea</div>
                            <div>&bull;</div>
                            <div>10 hours ago</div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="relative bg-gray-100 hover:bg-gray-200 border transition duration-150 ease-in rounded-full h-7 py-2 px-3">
                                <svg fill="currentColor" width="24" height="6"><path d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z" style="color: rgba(163, 163, 163, .5)"></svg>
                                <ul class="hidden absolute w-44 font-semibold bg-white shadow-dialog rounded-xl text-left md:ml-8 top-8 md:top-6 right-0 md:left-0 z-10">
                                    <li><a href="#" class="hover:bg-gray-100 hover:rounded-t-xl px-5 py-3 transition duration-150 ease-in block">Mark as spam</a></li>
                                    <li><a href="#" class="hover:bg-gray-100 hover:rounded-b-xl px-5 py-3 transition duration-150 ease-in block">Delete Post</a></li>
                                </ul>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- fin comment-container -->
        <div class="comment-container relative bg-white rounded-xl flex mt-4">
            <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
                <div class="flex-none">
                    <a href="#">
                        <img src="https://source.unsplash.com/200x200/?face&crop=face&v=4" alt="" class="w-14 h-14 rounded-xl">
                    </a>
                </div>
                <div class="md:mx-4">
                    <div class="text-gray-600 mt-3">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi doloribus saepe incidunt vitae repudiandae recusandae quae mollitia nihil aperiam similique.
                    </div>
    
                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                            <div class="font-bold text-gray-900">John Doe</div>
                            <div>&bull;</div>
                            <div>10 hours ago</div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="relative bg-gray-100 hover:bg-gray-200 border transition duration-150 ease-in rounded-full h-7 py-2 px-3">
                                <svg fill="currentColor" width="24" height="6"><path d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z" style="color: rgba(163, 163, 163, .5)"></svg>
                                <ul class="hidden absolute w-44 font-semibold bg-white shadow-dialog rounded-xl text-left md:ml-8 top-8 md:top-6 right-0 md:left-0 z-10">
                                    <li><a href="#" class="hover:bg-gray-100 hover:rounded-t-xl px-5 py-3 transition duration-150 ease-in block">Mark as spam</a></li>
                                    <li><a href="#" class="hover:bg-gray-100 hover:rounded-b-xl px-5 py-3 transition duration-150 ease-in block">Delete Post</a></li>
                                </ul>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- fin comment-container -->
    </div><!-- fin comments-container -->
</x-app-layout>