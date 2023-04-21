<button class="text-white focus:outline-none focus:ring-0 font-medium rounded-lg text-sm px-3.5 py-2.5 flex items-center space-x-2" id="btnNuevo" style="background: green"
    onclick="modal('{{ URL::route($ruta, ['listar' => 'SI']) }}', '{{ $titulo }}', this);">
    <i class="fa fa-plus fa-fw"></i>
    <p>{{ trans('maintenance.utils.import') }}</p>
</button>
