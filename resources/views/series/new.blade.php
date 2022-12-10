<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @if(strlen($serie->title) != strlen(utf8_decode($serie->title)))
                <span class="px-2 mr-2 text-xs border rounded border-rose-500 text-rose-500">foreign</span>
            @endif
            {{ $serie->title }}
        </h2> --}}
    </x-slot>

    {{-- <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8"> --}}
        {{-- @livewire('search-box') --}}
    {{-- </div> --}}

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        @foreach ($series as $serie)
            <h2>{{ $serie->title }}</h2>
            <p>{{ $serie->getLastSeason() }}</p>
        @endforeach

    </div>

</x-app-layout>
