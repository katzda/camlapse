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

<x-form
    action="{{ route('camlapse.edit', $camlapse->id) }}"
    title="{{ $camlapse->name }}"
    id="edit-timelapse"
    :fields="$camlapse->form"
    method="GET"
    submit="Edit"
    class="bg-gray-200"
/>

@endsection