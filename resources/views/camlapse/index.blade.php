@extends('layout')

@section('content')

<div class="">
    @foreach ($camlapses as $camlapse)

    <x-tile class="overflow-hidden rounded-lg bg-gray-200 text-center text-slate-900 shadow-sm">
        <a href="{{ route('camlapse.show', ['camlapse' => $camlapse['id']]) }}">
            <div class="px-10 py-4 hover:bg-sky-200">
                <h2 class="text-2xl font-semibold sm:text-3xl">{{$camlapse['name']}}</h2>
                <span class="text-sm text-slate-600 sm:text-base">{{ $camlapse['cron'] }} photoes / hour</span>
                <x-arrow-r />
            </div>
        </a>

        <video controls class="mx-auto">
            <source src="{{ asset('timelapse/'.$camlapse['id'].'/video.mp4?v=' . $camlapse['lastModified']) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <a class="my-3 inline-block font-medium text-blue-700 underline-offset-4 hover:underline" href="{{ asset('timelapse/'.$camlapse['id'].'/video.mp4' . '?v=' . $camlapse['lastModified']) }}" download="{{ strtolower(str_replace(' ', '_',$camlapse['name'])) }}">Download</a>

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