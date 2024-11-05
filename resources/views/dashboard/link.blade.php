<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Page A') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="pl-6 pr-6 pt-6 text-gray-900">

                    @if (isset($isImfeelinglucky) && $isImfeelinglucky)
                    <div class="p-4 mb-4 text-sm text-blue-800 bg-blue-100 rounded-lg" role="alert">
                        <span class="font-medium">Result:</span>
                        <p class="uppercase">
                            {{ $number }} {{ $result }}@if ($winnings) ${{ $winnings }}@endif
                        </p>
                    </div>
                    @endif

                    <div class="ms-3 pb-6 ">
                        <p>
                            Link: {{ $link->link }}
                        </p>
                        <p>
                            Link Expires: {{ $link->expires_at }}
                        </p>

                    </div>

                    <div class="pb-6">
                        <form method="POST" action="{{ route('dashboard.deactivateLink', ['link' => $link]) }}">
                            @csrf
                            <x-primary-button class="ms-3">
                                {{ __('Deactivate Link') }}
                            </x-primary-button>
                        </form>
                    </div>

                    <div class="pb-6">
                    <form method="POST" action="{{ route('dashboard.generateNewLink') }}">
                        @csrf
                        <x-primary-button class="ms-3">
                            {{ __('Generate New Link') }}
                        </x-primary-button>
                    </form>
                    </div>

                    <div class="pb-6">
                    <form method="POST" action="{{ route('dashboard.imfeelinglucky', ['link' => $link]) }}">
                        @csrf
                        <x-primary-button class="ms-3">
                            {{ __('Imfeelinglucky') }}
                        </x-primary-button>
                    </form>
                    </div>

                    <div class="pb-6">
                    <x-primary-button id="historyToggleButton" class="ms-3">
                        {{ __('History') }}
                    </x-primary-button>
                    </div>
                </div>

                <div class="p-6 text-gray-900">
                    <div id="historyToggleBlock" class="hidden mt-4 p-4 bg-white border border-gray-300 rounded shadow">
                        <ul>
                        @foreach ($historyEntries as $history)
                        <li>{{ $history->played_at }} {{ $history->number }} {{ $history->result }} @if ($history->winnings) ${{ $history->winnings }} @endif</li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


