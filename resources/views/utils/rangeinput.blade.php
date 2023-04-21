<label for="filas" class="font-medium text-sm text-gray-600">{{trans('maintenance.general.range')}}</label>
<select name="filas" id="filas" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full p-2.5" onchange="buscar('{{ $entidad }}');">
    @foreach ($cboRangeFilas as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
</select>
