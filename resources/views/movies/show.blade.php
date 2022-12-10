<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @if(strlen($movie->title) != strlen(utf8_decode($movie->title)))
                <span class="px-2 mr-2 text-xs border rounded border-rose-500 text-rose-500">foreign</span>
            @endif
            {{ $movie->title }}
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
                        Detailed information about the movie
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-12 sm:col-span-6">
                            <h3 class="text-lg font-medium text-gray-900">
                                Title
                            </h3>
                            <div class="mt-3 mb-3 text-sm text-gray-600">
                                <p>
                                    {{ $movie->title }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($hits)
                <div class="md:col-span-1 flex justify-between">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium text-gray-900">Possible downloads:</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Possible matches found. Since the information comes from torrentsearch engines, reliability is not high.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-12 sm:col-span-6">
                                <div class="mb-3 text-sm text-gray-600">
                                    @foreach($hits as $hit)
                                        @if ($hit->seeders && $hit->leechers > 0)
                                            <h4 class="text-md font-medium text-gray-900">
                                                {{ $hit->name }}
                                            </h4>
                                            <p class="mt-1 text-sm text-gray-600 mb-4">
                                                Size: {{ $hit->size }} <br />
                                                Date: {{ $hit->date }} <br />
                                                S/L: {{ $hit->seeders }}/{{ $hit->leechers }}<br />
                                                @if(isset($hit->magnet))
                                                    <a href="{{ $hit->magnet ?? '' }}" title="{{ $hit->magnet ?? '' }}" class="text-blue-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                                        </svg>
                                                        download (magnetized)
                                                    </a>
                                                @endif
                                            </p>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
