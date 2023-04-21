<div class="container" id="container">
    <div class="flex flex-col w-full space-y-6">
        <p class="text-4xl font-bold font-baloo">{{ $titulo_admin }}</p>
        <div class="flex items-center justify-between w-full py-8 px-12 rounded-xl bg-white">
            <div class="">
                @include('admin.room.admin', [
                    'action' => $ruta['search'],
                    'method' => 'POST',
                    'idform' => 'formBusqueda' . $entidad,
                    'cboRangeFilas' => $cboRangeFilas,
                ])
            </div>
            <div class="">
                @include('utils.addbutton', ['entidad' => $entidad, 'ruta' => $ruta['create'], 'titulo' => $titulo_registrar])
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
