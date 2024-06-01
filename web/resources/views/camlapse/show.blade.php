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
            'value' => $camlapse->name,
        ],
        'description' => [
            'title' => 'Description',
            'type' => 'text',
            'value' => $camlapse->description,
        ],
        'fph' => [
            'title' => 'fph',
            'type' => 'text',
            'value' => $camlapse->fph,
        ],
        'between_hour_start' => [
            'title' => 'Between hours start',
            'type' => 'text',
            'value' => $camlapse->between_hour_start,
        ],
        'between_hour_end' => [
            'title' => 'Between hours end',
            'type' => 'text',
            'value' => $camlapse->between_hour_end,
        ],
        'memory_period' => [
            'title' => 'Memory period',
            'type' => 'text',
            'value' => $camlapse->memory_period,
        ],
        'stop_datetime' => [
            'title' => 'Stop datetime',
            'type' => 'text',
            'value' => $camlapse->stop_datetime,
        ],
    ]

@endphp

<x-form
    action="{{ route('camlapse.edit', $camlapse->id) }}"
    title="View this item"
    id="edit-timelapse"
    :fields="$fields"
    method="GET"
    submit="Edit"
    class="bg-gray-200"
/>

@endsection