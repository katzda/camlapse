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
        'purpose' => [
            'title' => 'Purpose',
            'type' => 'text',
            'value' => $camlapse->purpose,
        ],
        'fph' => [
            'title' => 'fph',
            'type' => 'number',
            'value' => $camlapse->fph,
            'other' => [
                'min' => 1
            ]
        ],
        'between_time_start' => [
            'title' => 'Start time of day restriction',
            'type' => 'time',
            'value' => $camlapse->between_time_start->format("H:i"),
        ],
        'between_time_end' => [
            'title' => 'End time of day restriction',
            'type' => 'time',
            'value' => $camlapse->between_time_end->format("H:i"),
        ],
        'cron_day' => [
            'title' => 'Any particular day?',
            'type' => 'text',
            'value' => $camlapse->cron_day,
        ],
        'cron_weekday' => [
            'title' => 'Any particular weekday?',
            'type' => 'text',
            'value' => $camlapse->cron_weekday,
        ],
        'cron_month' => [
            'title' => 'Any particular month?',
            'type' => 'text',
            'value' => $camlapse->cron_month,
        ],
        'cron_year' => [
            'title' => 'Any particular year?',
            'type' => 'text',
            'value' => $camlapse->cron_year,
        ],
        'stop_datetime' => [
            'title' => 'Stop datetime',
            'type' => 'datetime-local',
            'value' => $camlapse->stop_datetime,
        ],
    ]

@endphp

<x-form
    action="{{ route('camlapse.edit', $camlapse->id) }}"
    title="{{ $camlapse->name }}"
    id="edit-timelapse"
    :fields="$fields"
    method="GET"
    submit="Edit"
    class="bg-gray-200"
/>

@endsection