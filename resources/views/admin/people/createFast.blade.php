@include('utils.errordiv', ['entidad' => $formData['entidad']])
@include('utils.formcrud', [
    'entidad' => $formData['entidad'],
    'formData' => $formData,
    'method' => $formData['method'],
    'route' => $formData['route'],
    'model' => isset($formData['model']) ? $formData['model'] : null,
])
<input type="hidden" name="room_id" value="{{ $formData['room_id'] }}">
<input type="hidden" name="from" id="from" value="{{ $formData['from'] }}">
<div class="flex space-x-6">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="dni">
            {{ trans('maintenance.admin.people.dni') }}
            <span onclick="searchClient()" class="bg-gray-100 text-gray-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded mr-2 dark:bg-gray-700 dark:text-gray-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                {{ __('maintenance.utils.search') }}
            </span>
        </label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="number" name="dni" id="dni"
            value="{{ isset($formData['model']) ? $formData['model']->dni : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="name">{{ trans('maintenance.admin.people.name') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="name" id="name"
            value="{{ isset($formData['model']) ? $formData['model']->name : null }}" required>
    </div>
</div>
<div class="flex space-x-6">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="address">{{ trans('maintenance.admin.people.address') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="address" id="address"
            value="{{ isset($formData['model']) ? $formData['model']->address : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="phone">{{ trans('maintenance.admin.people.phone') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="phone" id="phone"
            value="{{ isset($formData['model']) ? $formData['model']->phone : null }}">
    </div>
</div>

<div class="flex w-full mt-3">
    <div class="flex items-center justify-end space-x-5 py-3 w-full">
        <button class="px-5 py-2 rounded-lg bg-blue-corp text-white flex items-center space-x-2" id="btnGuardar" onclick="guardar('{{$formData['entidad']}}', this);">
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
        configurarAnchoModal('450');
        init(IDFORMMANTENIMIENTO + '{!! $formData['entidad'] !!}', 'M', '{!! $formData['entidad'] !!}');
    });

    function guardar (entidad, idboton, entidad2) {
        var idformulario = IDFORMMANTENIMIENTO + entidad;
        var data         = submitForm(idformulario);
        var respuesta    = '';
        var listar       = 'NO';
        if ($(idformulario + ' :input[id = "listar"]').length) {
            var listar = $(idformulario + ' :input[id = "listar"]').val();
        };
        var btn = $(idboton);
        data.done(function(msg) {
            var parseData = JSON.parse(msg);
            var selectClientId = document.getElementById("client_id");
            var selectClientBilling = document.getElementById("clientBilling");
            var from = document.getElementById("from");
            var option = document.createElement("option");
            option.text = parseData.name ?? parseData.social_reason;
            option.value = parseData.id;
            if(from.value == 'billing') {
                selectClientBilling.add(option);
                selectClientBilling.value = parseData.id;
            }else{
                selectClientId.add(option);
                selectClientId.value = parseData.id;
            }
            cerrarModal();
            Intranet.notificaciones("Accion realizada correctamente", "Realizado" , "success");
        }).fail(function(xhr, textStatus, errorThrown) {
            respuesta = xhr.responseText;
            if(JSON.parse(respuesta).message.trim()){
                mostrarErrores(xhr.responseText, idformulario, entidad, 1);
            }
            respuesta = 'ERROR';
        });
    }

    function searchClient()
    {
        var documentNumber = document.getElementById('dni').value;
        var type = '';
        if(documentNumber.length == 8){
            type = 'DNI';
        }else if( documentNumber.length == 11){
            type = 'RUC';
        }else{
            alert('El número de documento no es válido');
            return;
        }
        axios.get('{{ route($formData['routes']['searchClient']) }}' + '?number=' + documentNumber + '&type=' + type)
            .then(function (response) {
                var data = response.data;
                if (data.success) {
                    console.log(data);
                    document.getElementById('name').value = data.data.name;
                    document.getElementById('address').value = data.data.address;
                } else {
                    document.getElementById('name').value = '';
                    document.getElementById('address').value = '';
                    document.getElementById('phone').value = '';
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }
</script>
