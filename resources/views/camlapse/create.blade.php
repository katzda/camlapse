@extends('layout')

@section('content')

<x-form
    action="{{ route('camlapse.store') }}"
    title="Create a new time lapse!"
    id="new-timelapse"
    :fields="$camlapse->form"
    method="POST"
    :data="['devices' => $devices]"
    cancel_path="{{ route('camlapse.index') }}"
    class="bg-gray-200"
/>

@endsection