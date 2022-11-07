<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Series') }}
        </h2>
    </x-slot>

    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        @livewire('search-box')
    </div>

    <div>
        <div class="px-4 py-10 mx-auto max-w-7xl sm:px-6 lg:px-0">
            {{ $series->links() }}
            <table class="w-full mt-5 mb-5 table-auto">
                <thead>
                    <tr>
                        <th class="w-1/4 text-left">Title</th>
                        <th class="w-1/4 text-left">Rating</th>
                        <th class="w-1/4 text-left">Details?</th>
                        <th class="w-1/4 text-right">Watchlist</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($series as $serie)
                        <tr>
                            <td class="py-2 text-sm text-gray-600 truncate">@if(strlen($serie->title) != strlen(utf8_decode($serie->title))) <span class="px-2 mr-2 text-xs border rounded border-rose-500 text-rose-500">foreign</span> @endif <a href="{{ route('series.show', [$serie->id]) }}">{{ $serie->title }}</a></td>
                            <td class="py-2 text-sm text-gray-600">{{ $serie->rating }}</td>
                            <td class="py-2 text-sm text-gray-600">{{ $serie->detailed_info ? 'true' : 'false' }}</td>
                            <td class="py-2 text-sm text-right text-gray-600">
                                @livewire('mark-watchlist', ['serie' => $serie])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $series->links() }}
        </div>
    </div>
</x-app-layout>
