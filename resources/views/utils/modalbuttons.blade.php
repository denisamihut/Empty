<div class="flex items-center justify-end space-x-5 py-3 w-full">
    <button class="px-5 py-2 rounded-lg bg-blue-corp text-white flex items-center space-x-2" id="btnGuardar" onclick="guardar('{{$entidad}}', this);">
        <i class="far fa-save"></i>
        <p>{{$boton}}</p>
    </button>
    <button class="px-5 py-2 rounded-lg bg-red-500 text-white flex items-center space-x-2" id="btnCancelar{{$entidad}}" onclick="cerrarModal();">
        {{ trans('maintenance.utils.cancel') }}
    </button>
</div>
