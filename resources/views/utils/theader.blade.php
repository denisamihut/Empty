<thead class="text-base font-medium text-gray-900">
    <tr>
        @foreach($cabecera as $key => $value)
            <th scope="col" class="py-3 px-4 border-b border-gray-300" @if((int)$value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>{!! $value['valor'] !!}</th>
        @endforeach
    </tr>
</thead>
