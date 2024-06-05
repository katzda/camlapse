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
            'value' => $camlapse->name,
        ],
        'description' => [
            'title' => 'Description',
            'type' => 'text',
            'required' => false,
            'value' => $camlapse->description ?? '',
        ],
        'fph' => [
            'title' => 'fph',
            'type' => 'number',
            'required' => true,
            'value' => $camlapse->fph,
            'other' => [
                'min' => 1
            ]
        ],
        'between_time_start' => [
            'title' => 'Start time of day restriction',
            'type' => 'time',
            'required' => true,
            'value' => $camlapse->between_time_start,
        ],
        'between_time_end' => [
            'title' => 'End time of day restriction',
            'type' => 'time',
            'required' => true,
            'value' => $camlapse->between_time_end,
        ],
        'cron_day' => [
            'title' => 'Any particular day?',
            'type' => 'text',
            'required' => true,
            'value' => $camlapse->cron_day,
        ],
        'cron_weekday' => [
            'title' => 'Any particular weekday?',
            'type' => 'text',
            'required' => true,
            'value' => $camlapse->cron_weekday,
        ],
        'cron_month' => [
            'title' => 'Any particular month?',
            'type' => 'text',
            'required' => true,
            'value' => $camlapse->cron_month,
        ],
        'cron_year' => [
            'title' => 'Any particular year?',
            'type' => 'text',
            'required' => true,
            'value' => $camlapse->cron_year,
        ],
        'stop_datetime' => [
            'title' => 'Stop datetime',
            'type' => 'datetime-local',
            'required' => false,
            'value' => $camlapse->stop_datetime,
        ],
    ]

@endphp

<x-form
    action="{{ route('camlapse.update', $camlapse->id) }}"
    title="Edit your camlapse!"
    id="edit-timelapse"
    method="PUT"
    :fields="$fields"
    submit="Save"
    class="bg-gray-200"
/>

<x-form
    action="{{ route('camlapse.destroy', $camlapse->id) }}"
    id="delete-timelapse"
    method="DELETE"
    submit="Delete"
/>

@endsection