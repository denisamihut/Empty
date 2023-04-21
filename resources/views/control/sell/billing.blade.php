<div id="divBilling">
    <h1 class=" font-bold">{{ __('maintenance.control.management.billing') }}</h1>
    <hr>
    <div id="divErrors"></div>
    <div class="flex space-x-6 mt-3">
        <div class="flex flex-col space-y-1 w-full">
            <label class="font-medium text-sm text-gray-600" for="date">
                {{ __('maintenance.sell.date') }}
            </label>
            <input type="date" name="date" id="date" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" readonly value="{{ date('Y-m-d') }}">
        </div>
        <div class="flex flex-col space-y-1 w-full">
            <label class="font-medium text-sm text-gray-600" for="date">
                {{ __('maintenance.sell.number') }}
            </label>
            <input type="text" name="number" id="number" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" readonly value="{{ $number }}">
        </div>
    </div>
    <div class="flex space-x-6 mt-3">
        <div class="flex flex-col space-y-1 w-full">
            <label class="font-medium text-sm text-gray-600" for="payment_type">{{ trans('maintenance.control.management.paymentType') }}</label>
            <select onchange="handleChangePayments()" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" name="payment_type" id="payment_type">
                @foreach ($cboPaymentTypes as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div style="display: none" id="paymentDiv" class="flex flex-col space-y-1 w-full">
            <label id="labelType" class="font-medium text-sm text-gray-600" for="amounts_"></label>
            <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="number" name="amounts_" id="amounts_">
        </div>
    </div>
    <div id="divOtherPayments" class="grid grid-cols-4 gap-1 mt-3">
    </div>
    <div class="flex space-x-6 mt-3">
        <div class="flex flex-col space-y-1 w-full">
            <label class="font-medium text-sm text-gray-600" for="document">{{ trans('maintenance.control.management.documentType') }}</label>
            <select onchange="handleChangeDocumentType()" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" name="document" id="document">
                @foreach ($cboDocumentTypes as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div id="divDocumentNumber" style="display: none;" class="flex flex-col space-y-1 w-full">
            <label class="font-medium text-sm text-gray-600" for="documentNumber">{{ trans('maintenance.control.management.documentNumber') }}</label>
            <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5 bg-blue-100" type="text" name="documentNumber" id="documentNumber" required readonly>
        </div>
    </div>
    <div class="flex space-x-6 mt-3">
        <div class="flex flex-col space-y-1 w-full">
            <label class="font-medium text-sm text-gray-600" for="clientBilling">
                {{ trans('maintenance.control.management.clientBilling') }}
                <span
                    onclick="modal('{{ URL::route($routes['client'], ['from'=>'billing']) }}', 'Agregar Nuevo Cliente', this);"
                    class="bg-gray-100 text-gray-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded mr-2 dark:bg-gray-700 dark:text-gray-300 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="mr-1 w-3 h-3" fill="currentColor"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                    </svg>
                    {{ __('maintenance.utils.new') }}
                </span>
            </label>
            <select class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" name="clientBilling" id="clientBilling">
                @foreach ($cboClients as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
                </select>
        </div>
    </div>
</div>
<script>

    $( document ).ready( function() {
        var total = document.getElementById('totalCart').value;
        var input = document.getElementById('amounts_');
        input.value = total;
        input.setAttribute('readonly', true);
    });

    function save(e){
        e.preventDefault();
        verifyTotalAmounts();
        var total = document.getElementById('totalCart').value;
        var errorDiv = document.getElementById('divErrors');
        if(total == 0){
            Intranet.notificaciones('No hay productos seleccionados', 'Error!!', 'error');
            return;
        }
        var form = document.getElementById('formSell');
        var data = new FormData(form);
        var url = "{{ route($store) }}";
        var method = "POST";
        var axiosConfig = {
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        }

        axios.post(url, data, axiosConfig)
            .then(function (response) {
                if(response.data.success){
                    cargarRuta('{{ URL::to('cashregister') }}', 'main-container');
                    var win = window.open(response.data.url, '_blank');
                    win.focus();
                }
            })
            .catch(function (error) {
                if(error.response.status == 422){
                    var errors = error.response.data.errors;
                    var errorsHtml = '';
                    $.each(errors, function (key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorDiv.style.display = 'initial';
                    errorDiv.innerHTML = errorsHtml;
                }else{
                    Intranet.notificaciones('Ha ocurrido un error interno del sistema', 'Error!!', 'error');
                }
            });

        
    }

    function verifyTotalAmounts(){
        var paymentType = document.getElementById('payment_type').value;
        var total = document.getElementById('totalCart').value;
        if(paymentType == 5){
            var amounts = document.getElementsByClassName('input-amounts');
            var total = 0;
            for (var i = 0; i < amounts.length; i++) {
                total += parseFloat(amounts[i].value);
            }
            var totalReal = document.getElementById('totalCart').value;

            if(total != totalReal){
                Intranet.notificaciones('Los montos ingresados no coinciden con el total', 'Error!!', 'error');
                return;
            }
        }
    }


    function handleChangeDocumentType()
    {
        var documentType = document.getElementById('document').value;
        var divDocumentNumber = document.getElementById('divDocumentNumber');
        var selectClient = document.getElementById('clientBilling');

        axios.get('{{ route($routes['documentType']) }}' + '?type=' + documentType)
            .then(function (response) {
                document.getElementById('documentNumber').value = response.data.documentNumber;
                divDocumentNumber.style.display = 'initial';
                selectClient.innerHTML = '';
                var clients = response.data.cboClients;
                for (var key in clients) {
                    var option = document.createElement('option');
                    option.value = key;
                    option.text = clients[key];
                    selectClient.appendChild(option);
                }
            })
            .catch(function (error) {
                console.log(error);
                divDocumentNumber.style.display = 'none';
            });
    }

    function handleChangeAmounts(e){
        if(e.target.value <= 0){
            e.target.value = 0;
        }
        var amounts = document.getElementsByClassName('input-amounts');
        var total = 0;
        for (var i = 0; i < amounts.length; i++) {
            total += parseFloat(amounts[i].value);
        }
        var totalReal = document.getElementById('totalCart').value;

        if(total > totalReal){
            e.target.value = 0;
            Intranet.notificaciones('El monto ingresado es mayor al total', 'Error!!', 'error');
        }
    }

    function handleChangeTotalAmount(){
        var total = document.getElementById('totalCart').value;
        var input = document.getElementById('amounts_');
        input.value = total;
    }

    function handleChangePayments()
    {
        var container = document.getElementById('divOtherPayments');
        var payment_type = document.getElementById('payment_type').value;
        handleChangeTotalAmount();
        if(payment_type != 5) {
            container.innerHTML = '';
            document.getElementById('paymentDiv').style.display = 'inherit';
            document.getElementById('divOtherPayments').style.display = 'none';
            document.getElementById('labelType').innerHTML = document.getElementById('payment_type').options[document.getElementById('payment_type').selectedIndex].text;
        } else if (payment_type == 5){
            document.getElementById('paymentDiv').style.display = 'none';
            document.getElementById('divOtherPayments').style.display = 'grid';
            var options = document.getElementById('payment_type').options;
            var count = 0;
            for (var i = 0; i < options.length; i++) {
                if (options[i].value != 5 && options[i].value != 0) {
                    count++;
                }
            }
            container.innerHTML = '';
            for (var i = 0; i < count; i++) {
                var div = document.createElement('div');
                div.className = 'flex flex-col space-y-1 w-full';
                var label = document.createElement('label');
                label.className = 'font-medium text-sm text-gray-600';
                label.innerHTML = 'Monto ' + options[i+1].text;
                var input = document.createElement('input');
                input.className = 'border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5 input-amounts';
                input.type = 'number';
                input.name = 'amounts_' + options[i+1].value;
                input.id = 'amounts_'+ options[i+1].text;
                input.onchange = function(e){
                    handleChangeAmounts(e);
                }
                div.appendChild(label);
                div.appendChild(input);
                container.appendChild(div);
            }
        }else{
            return false;
        }
    }
</script>