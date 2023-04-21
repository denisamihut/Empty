<div class="w-full py-8 px-12 rounded-xl bg-white">
<button style="width: 120px; float:right" class="text-white bg-blue-500 hover:bg-yellow-500 focus:outline-none focus:ring-0 font-medium rounded-lg text-sm px-3.5 py-2.5 flex items-center space-x-2 mb-4" id="btnNuevo" onclick="cargarRuta('{{ URL::to($routes['back']) }}', 'main-container')">
    <i class="fas fa-undo"></i>
    <p>{{ trans('maintenance.utils.back') }}</p>
</button>
@include('utils.errordiv', ['entidad' => $formData['entidad']])
@include('utils.formcrud', [
    'entidad' => $formData['entidad'],
    'formData' => $formData,
    'method' => $formData['method'],
    'route' => $formData['route'],
    'model' => isset($formData['model']) ? $formData['model'] : null,
])
<input type="hidden" name="status" id="status" value="{{ $status }}">
<input type="hidden" name="room_id" value="{{ isset($formData['model']) ? $formData['model']->room->id : $room->id }}">
<h1 class=" font-bold mt-5">{{ __('maintenance.control.management.general') }}</h1>
<hr>
<div class="flex space-x-5 mt-5">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="number">{{ trans('maintenance.control.management.number') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5 bg-blue-100" type="text" name="number" id="number" readonly
            value="{{ isset($formData['model']) ? $formData['model']->number : $formData['number'] }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="date">{{ trans('maintenance.control.management.date') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5 bg-blue-100" type="date" name="date" id="date" readonly
            value="{{ isset($formData['model']) ? $formData['model']->created_at : $formData['today'] }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="start_date">{{ trans('maintenance.control.management.start_date') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="datetime-local" name="start_date" id="start_date"
            value="{{ isset($formData['model']) ? $formData['model']->start_date : $formData['today'] }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="end_date">{{ trans('maintenance.control.management.end_date') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="datetime-local" name="end_date" id="end_date"
            value="{{ isset($formData['model']) ? $formData['model']->end_date : $formData['today'] }}" required>
    </div>
</div>
<div class="flex space-x-6 mt-3">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="room">{{ trans('maintenance.control.management.room') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5 bg-blue-100" type="text" name="room" id="room"
            value="{{ isset($formData['model']) ? $formData['model']->room->name : $room->name }}" readonly>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="price">{{ trans('maintenance.control.management.room') }}</label>
        <input onchange="handleChangePrice()" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="number" name="price" id="price"
            value="{{ isset($formData['model']) ? $formData['model']->room->roomType->price : $room->roomType->price }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="days">{{ trans('maintenance.control.management.days') }}</label>
        <input onchange="handleChangeDays()" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="number" name="days" id="days"
            value="{{ isset($formData['model']) ? $formData['model']->days : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="amount">{{ trans('maintenance.control.management.amount') }}</label>
        <input onchange="handleChangeTotal()" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="number" name="amount" id="amount"
            value="{{ isset($formData['model']) ? $formData['model']->amount : null }}" required>
    </div>
</div>
<div class="flex space-x-6 mt-3">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="client_id">{{ trans('maintenance.control.management.client') }}
            <span onclick="modal('{{URL::route($routes['client'], ['status'=>$room['status'], 'room_id' => $room['id']])}}', 'Agregar Nuevo Cliente', this);" class="bg-gray-100 text-gray-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded mr-2 dark:bg-gray-700 dark:text-gray-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                </svg>
                {{ __('maintenance.utils.new') }}
              </span>
        </label>
        <select class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" name="client_id" id="client_id">
            @foreach ($cboClients as $key => $value)
                <option value="{{ $key }}" {{ isset($formData['model']) && $formData['model']->client_id == $key ? 'selected' : null }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="notes">{{ trans('maintenance.control.management.notes') }}</label>
        <textarea class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="notes" id="notes"
            value="{{ isset($formData['model']) ? $formData['model']->notes : null }}" required>
        </textarea>
    </div>
</div>
<div class="flex space-x-6 mt-3 ml-5 pl-4" >
    <input onchange="handleChangePayment()" name="billingToggle" class="form-check-input appearance-none w-9 -ml-10 rounded-full h-5 align-top bg-white bg-no-repeat bg-contain bg-gray-300 focus:outline-none cursor-pointer shadow-sm" type="checkbox" role="switch" id="billingToggle">
    <label class="form-check-label inline-block text-gray-800" for="billingToggle">{{ __('maintenance.control.management.charge') }}</label>
</div>
@include('control.management.billing', ['formData' => $formData, 'cboPaymentTypes' => $cboPaymentTypes, 'cboDocumentTypes' => $cboDocumentTypes, 'routes' => $routes])
<div class="flex items-center justify-end space-x-5 py-3 w-full">
    <button class="px-5 py-2 rounded-lg bg-blue-corp text-white flex items-center space-x-2" id="btnGuardar" onclick="guardar('{{$formData['entidad']}}', this);">
        <i class="far fa-save"></i>
        <p>{{__('maintenance.control.check-in')}}</p>
    </button>
</div>
</div>
</form>

<script type="text/javascript">
    $(document).ready(function() {
        configurarAnchoModal('600');
        init(IDFORMMANTENIMIENTO + '{!! $formData['entidad'] !!}', 'M', '{!! $formData['entidad'] !!}');
        document.getElementById('amount').readOnly = true;
        document.getElementById('billingToggle').disabled = true;
    });

    function handleChangeDays(){
        var days = document.getElementById('days').value;
        if(days != '' && days != null && days != undefined && days > 0){
            var price = document.getElementById('price').value;
            var amount = days * price;
            document.getElementById('amount').value = amount;
            document.getElementById('amount').readOnly = false;
            document.getElementById('billingToggle').disabled = false;
        }else{
            document.getElementById('days').value = 0;
            document.getElementById('amount').value = 0;
            document.getElementById('billingToggle').disabled = true;
        }
    }

    function handleChangePrice(){
        var price = document.getElementById('price').value;
        if(price != '' && price != null && price != undefined && price > 0){
            var days = document.getElementById('days').value;
            var amount = days * price;
            document.getElementById('amount').value = amount;
            document.getElementById('amount').readOnly = false;
        }else{
            document.getElementById('amount').value = 0;
            document.getElementById('price').value = 0;
        }
    }

    function handleChangeTotal()
    {
        var amount = document.getElementById('amount').value;
        if(amount != '' && amount != null && amount != undefined && amount > 0){
            document.getElementById('billingToggle').disabled = false;
        }else{
            document.getElementById('billingToggle').disabled = true;
        }
        handleChangePayment();
    }

    function handleChangePayment()
    {
        var divBilling = document.getElementById('divBilling');
        if(divBilling.style.display == 'none'){
            divBilling.style.display = 'block';
        }else{
            divBilling.style.display = 'none';
        }
    }

    function guardar (entidad, idboton, entidad2) {
        var idformulario = IDFORMMANTENIMIENTO + entidad;
        var data         = submitForm(idformulario);
        var respuesta    = '';
        var listar       = 'NO';
        if ($(idformulario + ' :input[id = "listar"]').length) {
            var listar = $(idformulario + ' :input[id = "listar"]').val();
        };
        data.done(function(msg) {
            var route = msg.routes;
            var url = msg.url;
            cargarRuta(route, 'main-container');
            if(url != '' && url != null && url != undefined){
                var win = window.open(url, '_blank');
                win.focus();
            }
        }).fail(function(xhr, textStatus, errorThrown) {
            respuesta = xhr.responseText;
            console.log(respuesta);
            if(JSON.parse(respuesta).message.trim()){
                mostrarErrores(xhr.responseText, idformulario, entidad, 1);
            }
            respuesta = 'ERROR';
        });
    }
</script>
