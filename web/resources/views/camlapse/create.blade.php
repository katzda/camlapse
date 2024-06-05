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
            'required' => true,
            'default' => '',
        ],
        'description' => [
            'title' => 'Description',
            'type' => 'text',
            'required' => false,
            'default' => '',
        ],
        'fph' => [
            'title' => 'fph',
            'type' => 'number',
            'required' => true,
            'default' => '1',
            'other' => [
                'min' => 1
            ]
        ],
        'between_time_start' => [
            'title' => 'Start time of day restriction',
            'type' => 'time',
            'required' => true,
            'default' => '00:00',
        ],
        'between_time_end' => [
            'title' => 'End time of day restriction',
            'type' => 'time',
            'required' => true,
            'default' => '23:59',
        ],
        'cron_day' => [
            'title' => 'Any particular day?',
            'type' => 'text',
            'required' => true,
            'default' => '*',
        ],
        'cron_weekday' => [
            'title' => 'Any particular weekday?',
            'type' => 'text',
            'required' => true,
            'default' => '*',
        ],
        'cron_month' => [
            'title' => 'Any particular month?',
            'type' => 'text',
            'required' => true,
            'default' => '*',
        ],
        'cron_year' => [
            'title' => 'Any particular year?',
            'type' => 'text',
            'required' => true,
            'default' => '*',
        ],
        'stop_datetime' => [
            'title' => 'Stop datetime',
            'type' => 'datetime-local',
            'required' => false,
            'default' => '',
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