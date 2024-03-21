@extends('layout')

@section('header')
    <div class="flex lg:justify-center lg:col-start-2">
        <x-button
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
                {{-- fph
                between_hour_start
                between_hour_end
                memory_period
                stop_datetime --}}

                <div>
                    <a href="{{ route('camlapse.show', ['camlapse' => $camlapse['id']]) }}" class="text-4xl">
                        <h2>{{$camlapse['name']}}<h2>
                    </a>
                    <span>{{ $camlapse['fph'] }} photoes / hour</span>
                </div>
            </x-tile>
        @endforeach
    </div>
@endsection