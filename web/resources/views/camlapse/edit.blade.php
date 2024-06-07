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
        'purpose' => [
            'title' => 'Purpose',
            'type' => 'text',
            'required' => false,
            'value' => $camlapse->purpose ?? '',
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
            'required' => false,
            'value' => $camlapse->between_time_start->format("H:i"),
        ],
        'between_time_end' => [
            'title' => 'End time of day restriction',
            'type' => 'time',
            'required' => false,
            'value' => $camlapse->between_time_end->format("H:i"),
        ],
        'cron_day' => [
            'title' => 'Any particular day?',
            'type' => 'text',
            'required' => true,
            'value' => $camlapse->cron_day,
            'info' => "Example: '*' | '1,12,31'",
        ],
        'cron_weekday' => [
            'title' => 'Any particular weekday?',
            'type' => 'text',
            'required' => true,
            'value' => $camlapse->cron_weekday,
            'info' => "Example: '*' | '0,3,6'",
        ],
        'cron_month' => [
            'title' => 'Any particular month?',
            'type' => 'text',
            'required' => true,
            'value' => $camlapse->cron_month,
            'info' => "Example: '*' | '0,3,11'",
        ],
        'cron_year' => [
            'title' => 'Any particular year?',
            'type' => 'text',
            'required' => true,
            'value' => $camlapse->cron_year,
            'info' => "Example: '*' | '2023,2024'",
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

<script>
    document.querySelector('#edit-timelapse-fph').onchange = function(event){
        var el = event.target;
        var parent = el.parentElement;
        var span = parent.querySelector("#fph_in_seconds");
        if(!span){
            span = document.createElement("div");
            span.setAttribute('id', 'fph_in_seconds');
            parent.appendChild(span);
        }

        let fph = parseInt(el.value);

        let sec = parseInt(3600 / fph);
        let min = parseInt(sec / 60);
        let rem = sec % 60;

        span.innerText = `A snapshop every ${min} min and ${rem} second"`
    }
</script>

@endsection