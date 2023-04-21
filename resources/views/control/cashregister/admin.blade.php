<form action="{{ route($action) }}" method="{{ $method }}" onsubmit="return false;" id="{{ $idform }}">
    @csrf
    <div class="flex space-x-10">
        <div class="flex flex-col space-y-1 w-full">
            <label for="name" class="font-medium text-sm text-gray-600">{{trans('maintenance.admin.cashregister.search')}}</label>
            <input type="text" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full p-2.5" name="name" id="name" placeholder="{{trans('maintenance.general.placeholder')}}">
        </div>
        <div class="flex flex-col space-y-1 w-full">
            <label for="name" class="font-medium text-sm text-gray-600">{{trans('maintenance.admin.cashregister.type')}}</label>
            <select class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" name="type" id="type" required>
                @foreach ($cboTypes as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col space-y-1 w-full">
            @include('utils.rangeinput', ['cboRangeFilas' => $cboRangeFilas, 'entidad' => $entidad])
        </div>
    </div>
    <input type="hidden" name="page" id="page" value="1">
    <input type="hidden" name="accion" id="accion" value="listar">
</form>
