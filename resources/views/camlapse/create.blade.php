@extends('layout')

@section('content')

<x-form
    action="{{ route('camlapse.store') }}"
    title="Create a new time lapse!"
    id="new-timelapse"
    :fields="$camlapse->form"
    method="POST"
    :data="['devices' => $devices]"
    class="bg-gray-200"
/>

@endsection