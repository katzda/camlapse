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

            <x-tile class="text-center bg-gray-200 rounded">
                <a href="{{ route('camlapse.show', ['camlapse' => $camlapse['id']]) }}">
                    <div class="hover:bg-sky-200 px-10 py-3">
                        <h2 class="text-4xl">{{$camlapse['name']}}<h2>
                        <span>{{ $camlapse->cron }} photoes / hour</span>
                        <x-arrow-r />
                    </div>
                </a>

                <video controls class="mx-auto">
                    <source src="{{ asset('timelapse/'.$camlapse['id'].'/video.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>

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