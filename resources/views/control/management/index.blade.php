@if($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
    <strong class="font-bold">{{ $errors->first('error') }}</strong>
  </div>
@endif
<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
        @foreach ($floors as $item)
            @if ($item['status'] == 'open')
            <li class="mr-2" role="presentation">
                <button onclick="cargarRuta('{{ route('management', ['id'=> $item['id']]) }}', 'main-container')" class="inline-block p-4 rounded-t-lg border-b-2 text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500 font-bold" id="{{ $item['id'] }}-tab" data-tabs-target="#{{ $item['name'] }}" type="button" role="tab" aria-controls="{{ $item['name'] }}" aria-selected="false">{{ $item['name'] }}</button>
            </li>
            @else
            <li class="mr-2" role="presentation">
                <button onclick="cargarRuta('{{ route('management', ['id' => $item['id']]) }}', 'main-container')" class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 dark:border-gray-700 font-bold" id="{{ $item['id'] }}-tab" data-tabs-target="#{{ $item['name'] }}" type="button" role="tab" aria-controls="{{ $item['name'] }}" aria-selected="false">{{ $item['name'] }}</button>
            </li>
            @endif
        @endforeach
    </ul>
</div>
<div class="grid grid-cols-4 gap-4" id="floorContainer">
    @php
        $id = $id ?? $floors->first()['id'];
    @endphp
    @foreach ($floors->where('id', $id)->first()['rooms'] as $room)
        @include('control.management.room', ['room' => $room, 'routes' => $routes])
    @endforeach
</div>
<script>
</script>