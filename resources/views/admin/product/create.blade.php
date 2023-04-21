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
        <label class="font-medium text-sm text-gray-600" for="name">{{ trans('maintenance.admin.product.name') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="name" id="name"
            value="{{ isset($formData['model']) ? $formData['model']->name : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600"
            for="sale_price">{{ trans('maintenance.admin.product.sale') }}</label>
            <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="sale_price" id="sale_price"
            value="{{ isset($formData['model']) ? $formData['model']->sale_price : null }}" required>
    </div>
</div>
<div class="flex space-x-6">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="purchase_price">{{ trans('maintenance.admin.product.purchase') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="purchase_price" id="purchase_price"
            value="{{ isset($formData['model']) ? $formData['model']->purchase_price : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600"
            for="unit_id">{{ trans('maintenance.admin.product.unit') }}</label>
        <select
            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full p-2.5"
            name="unit_id" id="unit_id" required>
            @foreach ($formData['cboUnit'] as $key => $value)
                <option value="{{ $key }}"
                    {{ isset($formData['model']) && $formData['model']->unit_id == $key ? 'selected' : null }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="flex space-x-6 mt-3">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600"
            for="category_id">{{ trans('maintenance.admin.product.category') }}</label>
        <select
            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full p-2.5"
            name="category_id" id="category_id" required>
            @foreach ($formData['cboCategory'] as $key => $value)
                <option value="{{ $key }}"
                    {{ isset($formData['model']) && $formData['model']->category_id == $key ? 'selected' : null }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600"
            for="branch_id">{{ trans('maintenance.admin.product.branch') }}</label>
        <select
            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full p-2.5"
            name="branch_id" id="branch_id" required>
            @foreach ($formData['cboBranch'] as $key => $value)
                <option value="{{ $key }}"
                    {{ isset($formData['model']) && $formData['model']->branch_id == $key ? 'selected' : null }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
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
