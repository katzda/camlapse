@props(['action', 'id', 'title', 'fields'])

<x-tile>
    <form action="{{ $action }}" method="POST" class="w-full text-center">

        <h1 class="font-bold text-4xl py-5">{{$title}}</h1>

        <div class="inline-block text-center py-3">

            @foreach ($fields as $fieldkey => $fieldvalue)
                <div class="table-row leading-10">
                    <label for="{{$id}}-{{$fieldkey}}" class="table-cell pr-3 text-right">{{ $fieldvalue['title']}}:</label>
                    <input id="{{$id}}-{{$fieldkey}}" name="{{$fieldkey}}" type="{{$fieldvalue['type']}}" class="table-cell my-1 px-2 text-black"/>
                    <span class="inline-block text-red-300 text-xl font-bold pl-3 w-2">@error($fieldkey)!@enderror</span>
                </div>
            @endforeach

            <ul class="pl-8 my-5">
                @foreach ($errors->toArray() as $name => $message)
                    <li class="text-left">{{ $name }} - {{ $message[0] }}</li>
                @endforeach
            </ul>

            <button type="submit" class="p-5 m-3 bg-zinc-800 w-full">Submit</button>
        </div>
    </form>
</x-tile>
