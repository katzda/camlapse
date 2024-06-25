@extends('layout')

@section('header')
    <div class="text-center rounded-lg bg-white">
        <x-button
            class="shadow-lg"
            href="{{ route('camlapse.create') }}"
            icon="book"
            title="Add Time Lapse"
        />
    </div>
@endsection

@section('content')

    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
        @foreach ($all as $camlapse)

            <x-tile>
                <a href="{{ route('camlapse.show', ['camlapse' => $camlapse['id']]) }}">
                    <x-tile>
                        <div>
                            <a href="https://stackoverflow.com/questions/17265429/add-2-pictures-to-video-with-durations?noredirect=1&lq=1">TODO</a>
                            <h2 class="text-4xl">{{$camlapse['name']}}<h2>
                            <span>{{ $camlapse['fph'] }} photoes / hour</span>
                        </div>
                        <x-arrow-r />
                    </x-tile>
                </a>

                @if(!$camlapse['is_active'])
                    <x-form
                        action="{{route('camlapse.activate', ['camlapse' => $camlapse['id']])}}"
                        id="activate-camlapse"
                        method="POST"
                        submit="Activate"
                    />
                @else
                    <x-form
                        action="{{route('camlapse.deactivate', ['camlapse' => $camlapse['id']])}}"
                        id="deactivate-camlapse"
                        method="POST"
                        submit="Deactivate"
                    />
                @endif
            </x-tile>
        @endforeach
    </div>
@endsection