@if(count($lista) == 0)
@include('utils.noresult')
@else
<table id="example1" class="w-full text-base font-medium text-center text-gray-500">
	@include('utils.theader', ['cabecera' => $cabecera])
	<tbody class="border-b border-gray-300">
		<?php
		$contador = $inicio + 1;
		?>
		@foreach ($lista as $key => $value)
        <tr>
			<td class="py-3 px-4">{{ $value->date }}</td>
            <td class="py-3 px-4">{{ $value->type }}</td>
            <td class="py-3 px-4">{{ $value->number }}</td>
            <td class="py-3 px-4">{{ $value->status }}</td>
            <td class="py-3 px-4">{{ $value->client->full_name }}</td>
			<td class="py-3 px-4">
					<a href="{{ URL::route($ruta['print'], ['type' => 'TICKET', 'id' => $value->id]) }}" role="button" target="_blank">
						<button type="button" class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-900 bg-orange-500 rounded-r-md border border-gray-200 hover:bg-gray-100 hover:text-yellow-700 focus:z-10">
						  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
						{{ __('maintenance.control.printticket') }}
						</button>
					  </a>
					<a href="{{ URL::route($ruta['print'], ['type' => 'A4', 'id' => $value->id]) }}" role="button" target="_blank">
						<button type="button" class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-900 bg-green-500 rounded-r-md border border-gray-200 hover:bg-gray-100 hover:text-yellow-700 focus:z-10">
						  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
						{{ __('maintenance.control.printA4') }}
						</button>
					  </a>
			</td>
		</tr>
		<?php
		$contador = $contador + 1;
		?>
		@endforeach
	</tbody>
    <caption style="caption-side:bottom">
        {!! $paginacion!!}
    </caption>
</table>
@endif
