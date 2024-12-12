@extends('layout')

@section('content')

<div class="w-full">
    <div class="p-4 bg-white rounded-lg shadow-md w-max mx-auto">
        <h1 class="text-xl font-bold mb-4 text-center">Camera Settings</h1>

        <span class="text-sm">{{ $device['name'] }}</span>

        <!-- Photo Area -->
        <div class="w-full lg:w-96 h-56 lg:h-96 bg-gray-200 rounded-lg flex items-center justify-center mb-4">
            <span id="photoPlaceholder" class="text-gray-500">Photo Preview</span>
            <img id="photoPreview" class="hidden w-full h-full object-cover rounded-lg" />
        </div>

        <form id="formSnapshot"
            action="{{ route('shoot.snapshot', ['hardware' => $device['id']]) }}"
            onclick="return false;"
        >
            <button
                id="captureButton"
                class="w-full px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
                Capture Image
            </button>
        </form>
    </div>
</div>

<script>
    const formSnapshot = document.getElementById('formSnapshot');
    const captureButton = document.getElementById('captureButton');
    const photoPreview = document.getElementById('photoPreview');
    const photoPlaceholder = document.getElementById('photoPlaceholder');

    captureButton.addEventListener('click', () => {
        snapshot();
    });

    function snapshot(file) {
        fetch(formSnapshot.action, {
            method: 'GET',
        })
        .then((response) => {
            return response.arrayBuffer();
        })
        .then((buffer) => {
            const base64String = btoa(
                new Uint8Array(buffer)
                    .reduce((data, byte) => data + String.fromCharCode(byte), '')
            );
            photoPreview.src = `data:image/jpeg;base64,${base64String}`;
            photoPreview.classList.remove('hidden');
            photoPlaceholder.classList.add('hidden')

        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
</script>
@endsection