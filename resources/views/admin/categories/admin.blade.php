<form action="{{ route($action) }}" method="{{ $method }}" onsubmit="return false;" id="{{ $idform }}">
    @csrf
    <div class="flex space-x-10">
        <div class="flex flex-col space-y-1">
            <label for="nombre" class="font-medium text-sm text-gray-600">{{trans('maintenance.admin.category.name')}}</label>
            <input type="text" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full p-2.5" name="nombre" id="nombre" placeholder="{{trans('maintenance.general.placeholder')}}">
        </div>
        <div class="flex flex-col space-y-1">
            @include('utils.rangeinput', ['cboRangeFilas' => $cboRangeFilas, 'entidad' => $entidad])
        </div>
    </div>
    <input type="hidden" name="page" id="page" value="1">
    <input type="hidden" name="accion" id="accion" value="listar">
</form>
