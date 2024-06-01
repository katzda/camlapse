@props(['action', 'id', 'title'=>'', 'fields' => [], 'method', 'submit' => 'Submit', 'class' => ''])

@php
    $is_method_standard = $method == 'GET' || $method == 'POST';
@endphp

<form action="{{ $action }}" {!! $is_method_standard ? "method=\"$method\"" : "method=\"POST\"" !!} class="w-full text-center p-3 {{ $class }} rounded-lg">

    @if(!$is_method_standard)
        @method($method)
    @endif

    @if(!empty($title))
        <h1 class="font-bold text-4xl py-5">{{$title}}</h1>
    @endif

    @if(!empty($fields))
        <div class="inline-block text-center py-3">

            @foreach ($fields as $fieldkey => $fieldvalue)
                @if($method != 'GET')
                    <div class="table-row leading-10">
                        <label for="{{$id}}-{{$fieldkey}}" class="table-cell pr-3 text-right">{{ $fieldvalue['title']}}:</label>
                        <input id="{{$id}}-{{$fieldkey}}" name="{{$fieldkey}}" type="{{$fieldvalue['type']}}" class="table-cell my-1 px-2 text-black" value="{{ old($fieldkey) ?? $fieldvalue['value'] ?? '' }}" />
                        <span class="inline-block text-red-300 text-xl font-bold pl-3 w-2">@error($fieldkey)!@enderror</span>
                    </div>
                @else
                    <div class="table-row leading-10">
                        <div class="table-cell pr-3 text-right">{{ $fieldvalue['title']}}:</div>
                        <div class="table-cell my-1 px-2 text-left">{{ $fieldvalue['value'] }}</div>
                    </div>
                @endif
            @endforeach

            @if($method!='GET' && !empty($errors->toArray()))
                <ul class="pl-8 my-5">
                    @foreach ($errors->toArray() as $name => $message)
                        <li class="text-left">{{ $name }} - {{ $message[0] }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

    <div class="px-5">
        <button type="submit" class="bg-blue-300 w-full h-[50px]">{{$submit}}</button>
    </div>
</form>
