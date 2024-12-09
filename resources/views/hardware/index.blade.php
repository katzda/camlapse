@extends('layout')

@section('content')

<div class="">

    <form action="{{ route('devices.refresh') }}" method="POST"
        class="my-10"
    >
        <div class="mx-auto w-5/6">
            <button
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 ring-2 active:ring-blue-400
                    h-[50px] w-full"
            >Refresh list of camera devices</button>
        </div>
    </form>

    <table class="table bg-gray-300 w-full text-center">
        <tr class="border-bottom border-b-2">
            <th>Settings</th>
            <th>Device</th>
            <th>OS Handle</th>
        </tr>
        @foreach ($devices as $index => $device)
        <tr>
            <td>
                <a href="{{ route('settings.show', $device['id']) }}"
                    class="w-[50px] inline-block text-red-600 hover:text-red-800"
                >
                    <span class="w-[20px] inline-block align-text-bottom">
                        @svg('zondicon-arrow-thick-right')
                    </span>
                </a>
            </td>
            <td>{{ $device['name'] }}</td>
            <td>{{ $device['device'] }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection