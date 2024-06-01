@extends('layout')

@section('header')
    <div class="flex lg:justify-center lg:col-start-2">
        <x-button
            href="{{ route('camlapse.index') }}"
            icon="book"
            title="Home"
        />
    </div>
@endsection


@section('content')

@php

    $fields = [
        'name' => [
            'title' => 'Name',
            'type' => 'text',
        ],
        'description' => [
            'title' => 'Description',
            'type' => 'text',
        ],
        'fph' => [
            'title' => 'fph',
            'type' => 'text',
        ],
        'between_hour_start' => [
            'title' => 'Between hours start',
            'type' => 'text',
        ],
        'between_hour_end' => [
            'title' => 'Between hours end',
            'type' => 'text',
        ],
        'memory_period' => [
            'title' => 'Memory period',
            'type' => 'text',
        ],
        'stop_datetime' => [
            'title' => 'Stop datetime',
            'type' => 'text',
        ],
    ]

@endphp

<x-form
    action="{{ route('camlapse.store') }}"
    title="Create a new time lapse!"
    id="new-timelapse"
    :fields="$fields"
    method="POST"
    class="bg-gray-200"
/>

@endsection