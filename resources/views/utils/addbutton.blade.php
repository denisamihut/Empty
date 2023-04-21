<button class="text-white bg-blue-corp hover:bg-yellow-500 focus:outline-none focus:ring-0 font-medium rounded-lg text-sm px-3.5 py-2.5 flex items-center space-x-2" id="btnNuevo"
    onclick="modal('{{ URL::route($ruta, ['listar' => 'SI', 'params' => $params ?? null]) }}', '{{ $titulo }}', this);">
    <i class="fa fa-plus fa-fw"></i>
    <p>{{ trans('maintenance.utils.new') }}</p>
</button>
