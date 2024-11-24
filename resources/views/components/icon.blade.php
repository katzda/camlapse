@props(['id'])

@switch($id)
    @case('home')
    <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#ff2d201a] sm:size-16">
        <svg class="size-5 sm:size-6" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 112.07" style="enable-background:new 0 0 122.88 112.07" xml:space="preserve">
            <g>
                <path fill="red" d="M61.44,0L0,60.18l14.99,7.87L61.04,19.7l46.85,48.36l14.99-7.87L61.44,0L61.44,0z M18.26,69.63L18.26,69.63 L61.5,26.38l43.11,43.25h0v0v42.43H73.12V82.09H49.49v29.97H18.26V69.63L18.26,69.63L18.26,69.63z" />
            </g>
        </svg>
    </div>
    @break
    @case('book')
    <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#ff2d201a] sm:size-16">
        <svg class="size-5 sm:size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path fill="red" d="M23 4a1 1 0 0 0-1.447-.894L12.224 7.77a.5.5 0 0 1-.448 0L2.447 3.106A1 1 0 0 0 1 4v13.382a1.99 1.99 0 0 0 1.105 1.79l9.448 4.728c.14.065.293.1.447.1.154-.005.306-.04.447-.105l9.453-4.724a1.99 1.99 0 0 0 1.1-1.789V4ZM3 6.023a.25.25 0 0 1 .362-.223l7.5 3.75a.251.251 0 0 1 .138.223v11.2a.25.25 0 0 1-.362.224l-7.5-3.75a.25.25 0 0 1-.138-.22V6.023Zm18 11.2a.25.25 0 0 1-.138.224l-7.5 3.75a.249.249 0 0 1-.329-.099.249.249 0 0 1-.033-.12V9.772a.251.251 0 0 1 .138-.224l7.5-3.75a.25.25 0 0 1 .362.224v11.2Z" />
            <path fill="red" d="m3.55 1.893 8 4.048a1.008 1.008 0 0 0 .9 0l8-4.048a1 1 0 0 0-.9-1.785l-7.322 3.706a.506.506 0 0 1-.452 0L4.454.108a1 1 0 0 0-.9 1.785H3.55Z" />
        </svg>
    </div>
    @break
    @case('list')
    <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#ff2d201a] sm:size-16">
        <svg class="size-5 sm:size-6" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 112.5" style="enable-background:new 0 0 122.88 112.5" xml:space="preserve">
            <g>
                <path fill="red" d="M12.56,87.39c6.93,0,12.56,5.62,12.56,12.56c0,6.93-5.62,12.56-12.56,12.56C5.62,112.5,0,106.88,0,99.95 C0,93.01,5.62,87.39,12.56,87.39L12.56,87.39z M35.07,88.24h86.38c0.79,0,1.43,0.64,1.43,1.43v19.93c0,0.79-0.64,1.43-1.43,1.43 H35.07c-0.79,0-1.43-0.64-1.43-1.43V89.67C33.64,88.88,34.29,88.24,35.07,88.24L35.07,88.24z M35.07,44.7h86.38 c0.79,0,1.43,0.64,1.43,1.43v19.93c0,0.79-0.64,1.43-1.43,1.43H35.07c-0.79,0-1.43-0.64-1.43-1.43V46.13 C33.64,45.34,34.29,44.7,35.07,44.7L35.07,44.7z M35.07,1.16h86.38c0.79,0,1.43,0.64,1.43,1.43v19.93c0,0.79-0.64,1.43-1.43,1.43 H35.07c-0.79,0-1.43-0.64-1.43-1.43V2.59C33.64,1.8,34.29,1.16,35.07,1.16L35.07,1.16z M12.56,43.69c6.93,0,12.56,5.62,12.56,12.56 c0,6.93-5.62,12.56-12.56,12.56C5.62,68.81,0,63.19,0,56.25C0,49.32,5.62,43.69,12.56,43.69L12.56,43.69z M12.56,0 c6.93,0,12.56,5.62,12.56,12.56c0,6.93-5.62,12.56-12.56,12.56C5.62,25.11,0,19.49,0,12.56C0,5.62,5.62,0,12.56,0L12.56,0z" />
            </g>
        </svg>
    </div>
    @break
    @case('new')
    <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#ff2d201a] sm:size-16">
        <svg class="size-5 sm:size-6" xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 512">
            <path fill="red" d="M256 0c141.387 0 256 114.614 256 256 0 141.387-114.613 256-256 256C114.614 512 0 397.387 0 256 0 114.614 114.614 0 256 0zm122.257 255.999v.004c0 12.532-10.321 22.794-22.79 22.794h-76.671v79.628c0 12.531-10.266 22.79-22.794 22.79h-.004c-12.531 0-22.793-10.324-22.793-22.79v-79.628h-76.668c-12.469 0-22.794-10.316-22.794-22.794v-.004c0-12.478 10.257-22.793 22.794-22.793h76.668V153.58c0-12.466 10.319-22.793 22.793-22.793h.004c12.475 0 22.794 10.258 22.794 22.793v79.626h76.671c12.533 0 22.79 10.267 22.79 22.793z" />
        </svg>
    </div>
    @break
@endswitch