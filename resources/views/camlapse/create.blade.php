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
    action="{{ route('camlapse.store') }}"
    title="Create a new time lapse!"
    id="new-timelapse"
    :fields="$camlapse->form"
    method="POST"
    class="bg-gray-200"
/>

@endsection