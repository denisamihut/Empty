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
        <label class="font-medium text-sm text-gray-600" for="name">{{ trans('maintenance.admin.business.name') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="name" id="name"
            value="{{ isset($formData['model']) ? $formData['model']->name : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="status">{{ trans('maintenance.admin.business.status') }}</label>
        <select class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" name="status" id="status" required>
            @foreach ($formData['cboStatus'] as $key => $value)
                <option value="{{ $key }}" {{ isset($formData['model']) && $formData['model']->status == $key ? 'selected' : null }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="flex space-x-6 mt-3">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="phone">{{ trans('maintenance.admin.business.phone') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="phone" id="phone"
            value="{{ isset($formData['model']) ? $formData['model']->phone : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="address">{{ trans('maintenance.admin.business.address') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="address" id="address"
            value="{{ isset($formData['model']) ? $formData['model']->address : null }}" required>
    </div>
</div>
<div class="flex space-x-6 mt-3">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="city">{{ trans('maintenance.admin.business.city') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="city" id="city"
            value="{{ isset($formData['model']) ? $formData['model']->city : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="email">{{ trans('maintenance.admin.business.email') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="email" name="email" id="email"
            value="{{ isset($formData['model']) ? $formData['model']->email : null }}" required>
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
