@include('utils.errordiv', ['entidad' => $formData['entidad']])
@include('utils.formcrud', [
    'entidad' => $formData['entidad'],
    'formData' => $formData,
    'method' => $formData['method'],
    'route' => $formData['route'],
    'model' => isset($formData['model']) ? $formData['model'] : null,
])
<div class="flex space-x-6">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="name">{{ trans('maintenance.utils.file') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="file" name="file" id="file"
         required>
    </div>
</div>
<div class="flex w-full">
    <div class="flex items-center justify-end space-x-5 py-3 w-full">
        <button class="px-5 py-2 rounded-lg bg-blue-corp text-white flex items-center space-x-2" id="btnGuardar" onclick="guardarArchivo('{{$formData['entidad']}}', this);">
            <i class="far fa-save"></i>
            <p>{{$formData['boton']}}</p>
        </button>
        <button class="px-5 py-2 rounded-lg bg-red-500 text-white flex items-center space-x-2" id="btnCancelar{{$formData['entidad']}}" onclick="cerrarModal();">
            {{ trans('maintenance.utils.cancel') }}
        </button>
    </div>

</div>
</form>
<script type="text/javascript">
    $(document).ready(function() {
        // configurarAnchoModal('550');
        init(IDFORMMANTENIMIENTO + '{!! $formData['entidad'] !!}', 'M', '{!! $formData['entidad'] !!}');
    });
</script>
