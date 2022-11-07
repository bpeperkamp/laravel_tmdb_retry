<div class="relative w-full">
    <input
        type="search"
        class="w-full h-16 py-2 pl-2 text-sm text-gray-900 bg-white border-0 rounded-md sm:text-md focus:border-transparent focus:border-0 focus:outline-none focus:ring-0 sm:pl-8 placeholder:italic placeholder:text-gray-600"
        placeholder="Have a question? Ask or enter a search term..."
        wire:model="term"
    >

    @if($term)
        @if($items)
            <div class="absolute w-full bg-white border-gray-200 rounded-b-2xl px-10 py-8 pt-4 shadow-lg list-group z-50 -mt-1.5">
                @if($items)
                    @foreach($items as $item)
                        <div class="pl-2 mb-4">
                            @if(isset($item['highlight']))
                                @if(isset($item['highlight']['title']) && !isset($item['highlight']['content']))
                                    <h4 class="text-sm text-gray-900"><a href="{{ route('series.show', [$item['_source']['id']]) }}">{!! $item['highlight']['title'][0] !!}</a></h4>
                                @elseif(isset($item['highlight']['title']) && isset($item['highlight']['content']))
                                    <h4 class="text-sm text-gray-900"><a href="{{ route('series.show', [$item['_source']['id']]) }}">{!! $item['highlight']['title'][0] !!}</a></h4>
                                    <p class="text-gray-500">{!! $item['highlight']['content'][0] !!}</p>
                                @elseif(!isset($item['highlight']['title']) && isset($item['highlight']['content']))
                                    <h4 class="text-sm text-gray-900"><a href="{{ route('series.show', [$item['_source']['id']]) }}">{{ $item['_source']['title'] }}</a></h4>
                                    <p class="text-gray-500">{!! $item['highlight']['content'][0] !!}</p>
                                @endif
                            @else
                                <h4><a href="{{ route('series.show', [$item['_source']['id']]) }}">{{ $item['_source']['title'] }}</a></h4>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        @endif
    </div>
@endif

<script>
    document.onkeydown = function (e) {
        // console.log(e);
    }
</script>
