@include('utils.errordiv', ['entidad' => $formData['entidad']])
@include('utils.formcrud', [
    'entidad' => $formData['entidad'],
    'formData' => $formData,
    'method' => $formData['method'],
    'route' => $formData['route'],
    'model' => isset($formData['model']) ? $formData['model'] : null,
])
<input type="hidden" name="concept_id" id="concept_id" value="2">
<div class="flex space-x-6">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="number">{{ trans('maintenance.control.cashregister.number') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="number" id="number" readonly
            value="{{ isset($formData['model']) ? $formData['model']->number : $formData['number'] }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="date">{{ trans('maintenance.control.cashregister.date') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="date" name="date" id="date" readonly
            value="{{ isset($formData['model']) ? $formData['model']->created_at : $formData['today'] }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="concept">{{ trans('maintenance.control.cashregister.concept') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="concept" id="concept" readonly
            value="{{ isset($formData['model']) ? $formData['model']->concept->name : 'CIERRE DE CAJA' }}" required>
    </div>
</div>
<div class="flex space-x-6 mt-3">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="amount">{{ trans('maintenance.control.cashregister.amount') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="number" name="amount" id="amount"
            value="{{ isset($formData['model']) ? $formData['model']->amount : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="amount">{{ trans('maintenance.control.cashregister.amountreal') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="number" name="amountreal" id="amountreal"
            value="{{ $formData['amountreal'] }}" required>
    </div>
</div>
<div class="flex space-x-6 mt-3">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="notes">{{ trans('maintenance.control.cashregister.notes') }}</label>
        <textarea class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="notes" id="notes"
            value="{{ isset($formData['model']) ? $formData['model']->notes : null }}" required>
        </textarea>
    </div>
</div>
<div class="flex w-full mt-3">
    @include('utils.modalbuttons', ['entidad' => $formData['entidad'], 'boton' => $formData['boton']])
</div>

</form>
<script type="text/javascript">
    $(document).ready(function() {
        configurarAnchoModal('450');
        init(IDFORMMANTENIMIENTO + '{!! $formData['entidad'] !!}', 'M', '{!! $formData['entidad'] !!}');
    });
</script>
