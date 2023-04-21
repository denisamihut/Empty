@if(count($lista) == 0)
@include('utils.noresult')
@else
<table id="example1" class="w-full text-base font-medium text-left text-gray-500">
	@include('utils.theader', ['cabecera' => $cabecera])
	<tbody class="border-b border-gray-300">
		<?php
		$contador = $inicio + 1;
		?>
		@foreach ($lista as $key => $value)
        <tr>
			<td class="py-3 px-4">{{ $value->name }}</td>
			<td class="py-3 px-4">{{ $value->email }}</td>
			<td class="py-3 px-4">{{ $value->usertype->name}}</td>
			<td class="py-3 px-4">
				@foreach ($value->branches as $item)
					{{ '- ' . $item->name }}<br>
				@endforeach
			</td>
			<td class="py-3 px-4">
				{{ $value->cashbox->name }}
			</td>
			<td class="py-3 px-4">{{ isset($value->people) ? $value->people->name : '-' }}</td>
			<td class="py-3 px-4">
				<div class="flex items-center space-x-4 text-lg">
					@include('utils.basebuttons', ['ruta' => $ruta, 'id' => $value->id, 'titulo_modificar' => $titulo_modificar, 'titulo_eliminar' => $titulo_eliminar, 'params1' => ['businessId'=>$value->business_id]])
					<button class="btn"  onclick="modal('{{URL::route($ruta['maintenance'], array($value->id, 'action'=>'PROFILEPHOTO', 'businessId' => $value->business_id, 'userId' => $value->id))}}', 'Cambiar Logo', this);">
						<i style="color: black" class="fas fa-images"></i>
					</button>	
				</div>
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
