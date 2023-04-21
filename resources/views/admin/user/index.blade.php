<div class="container" id="container">
    <div class="flex flex-col w-full space-y-6">
        <p class="text-4xl font-bold font-baloo">
            {{ $titulo_admin }}
            @if ($showBackBtn)
                <button style="width: 120px; float:right" class="text-white bg-blue-500 hover:bg-yellow-500 focus:outline-none focus:ring-0 font-medium rounded-lg text-sm px-3.5 py-2.5 flex items-center space-x-2" id="btnNuevo"
                onclick="cargarRuta('{{ URL::to($ruta['back']) }}', 'main-container')">
                    <i class="fas fa-undo"></i>
                    <p>{{ trans('maintenance.utils.back') }}</p>
                </button>
            @endif
        </p>
        <div class="flex items-center justify-between w-full py-8 px-12 rounded-xl bg-white">
            <div class="">
                @include('admin.user.admin', [
                    'action' => $ruta['search'],
                    'method' => 'POST',
                    'idform' => 'formBusqueda' . $entidad,
                    'cboRangeFilas' => $cboRangeFilas,
                    'businessId' => $businessId,
                ])
            </div>
            <div class="">
                @include('utils.addbutton', ['entidad' => $entidad, 'ruta' => $ruta['create'], 'titulo' => $titulo_registrar, 'params' => ['businessId' => $businessId]])
            </div>
        </div>
        <div class="overflow-x-auto relative py-8 px-12 rounded-xl bg-white" id="listado{{ $entidad }}"></div>
    </div>
</div>
<script>
    $(document).ready(function() {
        buscar('{{ $entidad }}');
        init(IDFORMBUSQUEDA + '{{ $entidad }}', 'B', '{{ $entidad }}');
        $(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="nombre"]').keyup(function (e) {
			var key = window.event ? e.keyCode : e.which;
			if (key == '13') {
				buscar('{{ $entidad }}');
			}
		});
    });
</script>
