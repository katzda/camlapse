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

    <div class="">
        @foreach ($all as $camlapse)

            <x-tile>
                <x-tile>

                    <a href="{{ route('camlapse.show', ['camlapse' => $camlapse['id']]) }}">
                        <div>
                            <h2 class="text-4xl">{{$camlapse['name']}}<h2>
                            <span>{{ $camlapse['fph'] }} photoes / hour</span>
                        </div>
                        <x-arrow-r />
                    </a>

                    <video width="640" height="360" controls>
                        <source src="{{ asset($camlapse['id'].'/video.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>

                </x-tile>

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