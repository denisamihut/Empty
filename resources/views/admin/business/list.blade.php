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
			<td class="py-3 px-4">{{ $value->statusBusiness }}</td>
			<td class="py-3 px-4">{{ $value->email . ' ' . $value->phone }}</td>
			<td class="py-3 px-4">{{ $value->address }}</td>
			<td class="py-3 px-4">
				<div class="flex items-center space-x-4 text-lg">
					<button class="btn" onclick="cargarRuta('{{URL::route($ruta['branches'], [$value->id, 'action'=>'LIST', 'businessId' => $value->id])}}', 'main-container');">
						<i style="color: purple" class="fas fa-building"></i>
					</button>
					<button class="btn" onclick="cargarRuta('{{URL::route($ruta['users'], ['action'=>'LIST', 'businessId' => $value->id])}}', 'main-container');">
						<i style="color: green" class="fas fa-users"></i>
					</button>
					<button class="btn" onclick="cargarRuta('{{URL::route($ruta['cashboxes'], ['action'=>'LIST', 'businessId' => $value->id])}}', 'main-container');">
						<i style="color: rgb(117, 125, 9)" class="fas fa-store"></i>
					</button>
					<button class="btn" onclick="cargarRuta('{{URL::route($ruta['payments'], ['action'=>'LIST', 'businessId' => $value->id])}}', 'main-container');">
						<i style="color: rgb(13, 180, 218)" class="fas fa-sack-dollar"></i>
					</button>
					@include('utils.basebuttons', ['ruta' => $ruta, 'id' => $value->id, 'titulo_modificar' => $titulo_modificar, 'titulo_eliminar' => $titulo_eliminar])
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
