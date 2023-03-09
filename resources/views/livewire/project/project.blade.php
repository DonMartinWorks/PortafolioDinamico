<div class="max-w-2xl mx-auto py-16 sm:py-24 lg:max-w-none">
    <div class="flex items-center">
        <h2 class="text-2xl font-extrabold text-gray-900 mr-5" id="{{ __('projects') }}">Proyectos</h2>

        <!-- Boton add -->
        <x-actions.action wire:click.prevent="create" title="{{ __('New Project') }}"
            class="text-gray-800 hover:text-gray-600">
            <x-icons.add />
        </x-actions.action>
    </div>
    <div class="space-y-12 lg:space-y-6 lg:grid lg:grid-cols-3 lg:gap-x-6">
        @forelse ($projects as $project)
            <div class="group mt-6" wire:key="{{ $project->id }}">
                <div
                    class="relative w-full h-80 bg-white rounded-lg overflow-hidden group-hover:opacity-75 sm:aspect-w-2 sm:aspect-h-1 sm:h-64 lg:aspect-w-1 lg:aspect-h-1">
                    <a href="#" wire:click.prevent="loadProject({{ $project->id }})">
                        <img src="{{ $project->image_url }}" alt="Project Image"
                            class="w-full h-full object-center object-cover">
                    </a>
                </div>
                <h3 class="mt-6 text-base font-semibold text-gray-900">
                    <a href="#" wire:click.prevent="loadProject({{ $project->id }})">{{ $project->name }}</a>
                </h3>

                <!-- Boton edit and delete -->
                <div class="flex justify-center text-center mt-3" x-data>
                    <x-actions.action wire:click.prevent="loadProject({{ $project->id }}, false)"
                        title="{{ __('Edit Project') }}: {{ $project->name }}"
                        class="text-gray-800 hover:text-gray-600">
                        <x-icons.pencil />
                    </x-actions.action>
                    <x-actions.delete eventName="deleteProject" :object="$project" />
                </div>
            </div>
        @empty
            <h3>{{ __('There are no projects to show!') }}</h3>
        @endforelse
    </div>

    <!-- Boton Mostrar mas / Mostrar menos -->

    <!-- Info Modal -->
    <div x-data="{ open: @entangle('openModal').defer }" @keydown.window.escape="open = false" x-show="open" class="relative z-10"
        aria-labelledby="modal-title" x-ref="dialog" aria-modal="true">
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            x-description="Background backdrop, show/hide based on modal state."
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-center justify-center min-h-full p-4 text-center sm:p-0">
                <div x-show="open" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-description="Modal panel, show/hide based on modal state."
                    class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-xl sm:w-full"
                    @click.away="open = false">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                {{ $currentProject->name }}
                            </h3>

                            <div class="mt-4">
                                <p class="text-sm text-gray-500">
                                    {{ $currentProject->description }}
                                </p>
                            </div>

                            <div class="mt-2">
                                @if (!$currentProject->video_link)
                                    <div
                                        class="relative w-full h-80 bg-white rounded-lg overflow-hidden group-hover:opacity-75 sm:aspect-w-2 sm:aspect-h-1 sm:h-64 lg:aspect-w-1 lg:aspect-h-1">
                                        <img src="{{ $currentProject->image_url }}" alt="{{ __('Project Image') }}"
                                            class="w-full h-full object-center object-cover">
                                    </div>
                                @else
                                    <iframe class="w-full" width="560" height="315"
                                        src="https://www.youtube.com/embed/{{ $currentProject->video_code }}"
                                        title="{{ __('YouTube video player') }}" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                                @endif
                            </div>

                            <div class="flex mt-2">
                                @if ($currentProject->url)
                                    <a href="{{ $currentProject->url }}" class="text-gray-800 hover:text-purple-600"
                                        title="{{ __('See live proyect') }}" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                                        </svg>

                                    </a>
                                @endif

                                @if ($currentProject->repo_url)
                                    <a href="{{ $currentProject->repo_url }}"
                                        class="text-gray-800 hover:text-purple-600" title="{{ __('Repository') }}"
                                        target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm"
                            @click="open = false">
                            {{ __('Close') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SlideOver -->
    <x-modal.slideover>
        <x-forms.create-project :currentProject="$currentProject" :imageFile="$imageFile" />
    </x-modal.slideover>
</div>