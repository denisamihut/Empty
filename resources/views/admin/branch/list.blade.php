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
			<td class="py-3 px-4">
				{{ $value->name }}
				@if ($value->is_main)
					<span class="bg-yellow-100 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900">Principal</span>
				@endif
			</td>
			<td class="py-3 px-4">{{ $value->statusBranch }}</td>
			<td class="py-3 px-4">{{ $value->email . ' ' . $value->phone }}</td>
			<td class="py-3 px-4">{{ $value->address }}</td>
			<td class="py-3 px-4">
				<div class="flex items-center space-x-4 text-lg">
					<button class="btn"  onclick="modal('{{URL::route($ruta['maintenance'], array($value->id, 'action'=>'SETTINGS', 'businessId' => $value->business_id))}}', '{{$settingsTitle}}', this);">
						<i style="color: orange" class="fas fa-wrench"></i>
					</button>
					@include('utils.basebuttons', ['ruta' => $ruta, 'id' => $value->id, 'titulo_modificar' => $titulo_modificar, 'titulo_eliminar' => $titulo_eliminar, 'params1' => ['businessId'=>$value->business_id]])
					@if ($value->settings)
						<button class="btn"  onclick="modal('{{URL::route($ruta['maintenance'], array($value->id, 'action'=>'PROFILEPHOTO', 'businessId' => $value->business_id))}}', 'Cambiar Logo', this);">
							<i style="color: black" class="fas fa-images"></i>
						</button>	
					@endif
					@if (!$value->is_main)
						<button title="Hacer Principal" class="btn" onclick="modal('{{URL::route($ruta['maintenance'], array($value->id, 'action'=>'IS_MAIN', 'businessId' => $value->business_id ))}}', 'Cambiar sucursal principal', this);">
							<i style="color: violet" class="fas fa-check-circle"></i>
						</button>
					@endif
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
