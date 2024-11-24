@extends('layout')

@section('content')

<x-form
    action="{{ route('camlapse.edit', $camlapse->id) }}"
    title="{{ $camlapse->name }}"
    id="edit-timelapse"
    :fields="$camlapse->form"
    method="GET"
    submit="Edit"
    class="bg-gray-200" />

@endsection