@extends('layout')

@section('content')

<div class="">

    <form action="{{ route('devices.refresh') }}" method="POST">
        <button>Refresh list of camera devices</button>
    </form>

    Found Devices:
    <table class="table">
        <tr>
            <th>Device</th>
            <th>OS Handle</th>
            <th>Order</th>
        </tr>
        @foreach ($devices as $index => $device)
        <tr>
            <td>{{ $device['name'] }}</td>
            <td>{{ $device['device'] }}</td>
            <td>{{ $device['order'] }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection