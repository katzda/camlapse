@extends('layout')

@section('content')

<div class="">
    @foreach ($camlapses as $camlapse)

    <x-tile class="text-center bg-gray-200 rounded">
        <a href="{{ route('camlapse.show', ['camlapse' => $camlapse['id']]) }}">
            <div class="hover:bg-sky-200 px-10 py-3">
                <h2 class="text-4xl">{{$camlapse['name']}}
                    <h2>
                        <span>{{ $camlapse['cron'] }} photoes / hour</span>
                        <x-arrow-r />
            </div>
        </a>

        <video controls class="mx-auto">
            <source src="{{ asset('timelapse/'.$camlapse['id'].'/video.mp4?v=' . $camlapse['lastModified']) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <a href="{{ asset('timelapse/'.$camlapse['id'].'/video.mp4' . '?v=' . $camlapse['lastModified']) }}" download="{{ strtolower(str_replace(' ', '_',$camlapse['name'])) }}">download</a>

        @if(!$camlapse['is_active'])
        <x-form
            action="{{route('camlapse.activate', ['camlapse' => $camlapse['id']])}}"
            id="activate-camlapse"
            method="POST"
            submit="Activate" />
        @else
        <x-form
            action="{{route('camlapse.deactivate', ['camlapse' => $camlapse['id']])}}"
            id="deactivate-camlapse"
            method="POST"
            submit="Deactivate" />
        @endif

    </x-tile>
    @endforeach
</div>
@endsection