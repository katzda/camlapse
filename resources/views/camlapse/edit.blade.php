@extends('layout')

@section('content')

<x-form
    action="{{ route('camlapse.update', $camlapse->id) }}"
    title="Edit your camlapse!"
    id="edit-timelapse"
    method="PUT"
    :data="['devices' => $devices]"
    :fields="$camlapse->form"
    submit="Save"
    class="bg-gray-200" />

<x-form
    action="{{ route('camlapse.destroy', $camlapse->id) }}"
    id="delete-timelapse"
    method="DELETE"
    submit="Delete" />

<script>
    document.querySelector('#edit-timelapse-fph').onchange = function(event) {
        var el = event.target;
        var parent = el.parentElement;
        var span = parent.querySelector("#fph_in_seconds");
        if (!span) {
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