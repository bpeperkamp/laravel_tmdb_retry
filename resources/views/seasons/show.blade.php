<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @if(strlen($serie->title) != strlen(utf8_decode($serie->title)))
                <span class="px-2 mr-2 text-xs border rounded border-rose-500 text-rose-500">foreign</span>
            @endif
            {{ $serie->title }} - {{ $season->name }}
        </h2>
    </x-slot>

    {{-- <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8"> --}}
        {{-- @livewire('search-box') --}}
    {{-- </div> --}}

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">Details</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Detailed information about the season
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-12 sm:col-span-6">
                            <h3 class="text-lg font-medium text-gray-900">
                                Name
                            </h3>
                            <div class="mt-3 mb-3 text-sm text-gray-600">
                                <p>
                                    {{ $season->name }}
                                </p>
                            </div>

                            @if($season->overview)
                                <h3 class="text-lg font-medium text-gray-900">
                                    Overview
                                </h3>
                                <div class="mt-3 mb-3 text-sm text-gray-600">
                                    <p>
                                        {{ $season->overview }}
                                    </p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-jet-section-border />

        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">Episodes</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        All episodes known
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-12 sm:col-span-6">

                            <h3 class="text-lg font-medium text-gray-900 mb-8">
                                {{ $season->name }} - {{ count($episodes) }} episodes:
                            </h3>

                            @php
                                $count = 0;
                            @endphp

                            @foreach ($episodes as $episode)

                                @php
                                    $count++
                                @endphp

                                <h4 class="text-md font-medium text-gray-900">{{ $episode->name }}</h4>
                                <p class="text-sm text-gray-600">
                                    @if ($episode->overview)
                                        {{ $episode->overview }}
                                    @else
                                        No summary found
                                    @endif
                                </p>

                                @if(count($episodes) > 1 && !(count($episodes) == $count))
                                    <div class="hidden sm:block">
                                        <div class="py-4">
                                            <div class="border-t border-gray-200"></div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
