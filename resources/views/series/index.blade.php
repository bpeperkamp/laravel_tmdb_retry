<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 inline">
            {{ __('Series') }}
        </h2>
        <a href="{{ route('series.watchlist') }}" class="inline text-gray-600 ml-5">on watchlist</a>
    </x-slot>

    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        @livewire('search-box')
    </div>

    <div id="dynamicTable" class="hidden" style="margin-top: 300px;">
        <!-- Replace below with Livewire -->
        <script>
            document.addEventListener('searchItems', event => {
                var foundItems = [];
                var dynamicTable = document.getElementById('dynamicTable');
                if (event.detail.items) {
                    foundItems = event.detail.items;
                    dynamicTable.style.display = 'block';
                } else {
                    foundItems = [];
                    dynamicTable.style.display = 'none';
                }
                if (event.detail.items) {
                    var rows = [];
                    foundItems.forEach(element => {
                        var link = '<a href="series/'+element._source.id+'">'+element._source.title+'</a>';
                        var row = ['<tr><td class="py-2 text-sm text-gray-600 truncate">'+link+'</td><td class="py-2 text-sm text-gray-600 truncate">'+(element._source.tagline ?? '')+'</td></tr>'];
                        rows.push(row);
                    });
                    document.getElementById("dynamic").innerHTML = new Array(rows.join(' '));
                }
            })
        </script>
        <div class="px-4 py-10 mx-auto max-w-7xl sm:px-6 lg:px-0">
            <table class="w-full mt-5 mb-5 table-auto">
                <thead>
                    <tr>
                        <th class="w-1/4 text-left">Title</th>
                        <th class="w-1/4 text-left">Tagline</th>
                        <th class="w-1/4 text-right">Watchlist</th>
                    </tr>
                </thead>
                <tbody id="dynamic">
                </tbody>
            </table>
        </div>
    </div>

    <div id="staticTable">
        <div class="px-4 py-10 mx-auto max-w-7xl sm:px-6 lg:px-0">
            {{ $series->links() }}
            <table class="w-full mt-5 mb-5 table-auto">
                <thead>
                    <tr>
                        <th class="w-1/4 text-left border-b border-gray-200">Title</th>
                        <th class="w-1/4 text-left border-b border-gray-200">Tagline</th>
                        <th class="w-1/4 text-right border-b border-gray-200">Watchlist</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($series as $serie)
                        <tr>
                            <td class="py-2 text-sm text-gray-600 border-b border-gray-200 truncate">
                                @if(strlen($serie->title) != strlen(utf8_decode($serie->title))) <span class="px-2 mr-2 text-xs border rounded border-rose-500 text-rose-500">foreign</span> @endif <a href="{{ route('series.show', [$serie->id]) }}">{{ $serie->title }}</a>
                            </td>
                            <td class="py-2 text-sm text-gray-600 border-b border-gray-200">
                                {{ $serie->details->tagline ?? null }}
                            </td>
                            <td class="py-2 text-sm text-right text-gray-600 border-b border-gray-200">
                                @livewire('mark-watchlist', ['serie' => $serie])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $series->links() }}
        </div>
    </div>

<script>
    var staticTable = document.getElementById('staticTable');
    document.addEventListener('tableVisible', event => {
        if (event.detail.value === true) {
            staticTable.style.display = 'none';
        } else {
            staticTable.style.display = 'block';
        }
    })
</script>

</x-app-layout>
