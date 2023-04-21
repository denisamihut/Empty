@include('utils.errordiv', ['entidad' => $formData['entidad']])
@include('utils.formcrud', [
    'entidad' => $formData['entidad'],
    'formData' => $formData,
    'method' => $formData['method'],
    'route' => $formData['route'],
    'model' => isset($formData['model']) ? $formData['model'] : null,
])

<input type="hidden" name="action" value="{{ $formData['action'] }}">
<input type="hidden" name="business_id" value="{{ $formData['businessId'] }}">
<input type="hidden" name="branch_id" value="{{ $formData['branchId'] }}">
<div class="flex space-x-6">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="razon_social">{{ trans('maintenance.admin.setting.razonsocial') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="razon_social" id="razon_social"
            value="{{ isset($formData['model']) ? $formData['model']->razon_social : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="nombre_comercial">{{ trans('maintenance.admin.setting.nombrecomercial') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="nombre_comercial" id="nombre_comercial"
            value="{{ isset($formData['model']) ? $formData['model']->nombre_comercial : null }}" required>
    </div>
</div>
<div class="flex space-x-6 mt-3">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="ruc">{{ trans('maintenance.admin.setting.ruc') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="ruc" id="ruc"
            value="{{ isset($formData['model']) ? $formData['model']->ruc : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="direccion">{{ trans('maintenance.admin.setting.direccion') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="direccion" id="direccion"
            value="{{ isset($formData['model']) ? $formData['model']->direccion : null }}" required>
    </div>
</div>
<div class="flex space-x-6 mt-3">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="telefono">{{ trans('maintenance.admin.setting.telefono') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="telefono" id="telefono"
            value="{{ isset($formData['model']) ? $formData['model']->telefono : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="email">{{ trans('maintenance.admin.setting.email') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="email" name="email" id="email"
            value="{{ isset($formData['model']) ? $formData['model']->email : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="serie">{{ trans('maintenance.admin.setting.serie') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="serie" name="serie" id="serie"
            value="{{ isset($formData['model']) ? $formData['model']->serie : null }}" required>
    </div>
</div>
<div class="flex space-x-6 mt-3">
    <label for="billing" class="inline-flex items-center">
        <input id="billing" type="checkbox"
            class="rounded border-gray-300 text-blue-corp shadow-sm focus:outline-none focus:ring-0 focus:border-gray-300"
            name="remember">
        <span class="ml-2 text-sm font-medium text-gray-900">{{ trans('maintenance.admin.setting.billing') }}</span>
    </label>
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
