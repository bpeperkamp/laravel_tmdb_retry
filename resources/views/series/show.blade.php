<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @if(strlen($serie->title) != strlen(utf8_decode($serie->title)))
                <span class="px-2 mr-2 text-xs border rounded border-rose-500 text-rose-500">foreign</span>
            @endif
            {{ $serie->title }}
        </h2>
    </x-slot>

{{--    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">--}}
{{--        @livewire('search-box')--}}
{{--    </div>--}}

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">

            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">Details</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Detailed information about the series
                    </p>
                </div>
                <div class="px-4 sm:px-0">
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
                                    {{ $serie->title }}
                                </p>
                            </div>

                            <h3 class="text-lg font-medium text-gray-900">
                                Overview
                            </h3>
                            <div class="mt-3 mb-3 text-sm text-gray-600">
                                <p>
                                    {{ $serie->details->overview }}
                                </p>
                            </div>

                            <h3 class="text-lg font-medium text-gray-900">
                                Language
                            </h3>
                            <div class="mt-3 mb-3 text-sm text-gray-600">
                                <p>
                                    {{ $serie->details->original_language }}
                                </p>
                            </div>

                            <h3 class="text-lg font-medium text-gray-900">
                                Airdates
                            </h3>
                            <div class="mt-3 mb-3 text-sm text-gray-600">
                                <p>
                                    Started: {{ $serie->details->first_air_date }} <br />
                                    Ended: {{ $serie->details->last_air_date }}
                                </p>
                            </div>

                            <h3 class="text-lg font-medium text-gray-900">
                                Status
                            </h3>
                            <div class="mt-3 mb-3 text-sm text-gray-600">
                                <p>
                                    {{ $serie->details->status }}
                                </p>
                            </div>

                            <h3 class="text-lg font-medium text-gray-900">
                                Adult content
                            </h3>
                            <div class="mt-3 mb-3 text-sm text-gray-600">
                                <p>
                                    {{ $serie->details->adult ? 'true' : 'false' }}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <x-jet-section-border />
    </div>
</x-app-layout>
