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
        <label class="font-medium text-sm text-gray-600" for="name">{{ trans('maintenance.admin.menuoption.name') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="name" id="name"
            value="{{ isset($formData['model']) ? $formData['model']->name : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="link">{{ trans('maintenance.admin.menuoption.link') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="link" id="link"
            value="{{ isset($formData['model']) ? $formData['model']->link : null }}" required>
    </div>
</div>
<div class="flex space-x-6">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="icon">{{ trans('maintenance.admin.menuoption.icon') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="icon" id="icon"
            value="{{ isset($formData['model']) ? $formData['model']->icon : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="order">{{ trans('maintenance.admin.menuoption.order') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="number" name="order" id="order"
            value="{{ isset($formData['model']) ? $formData['model']->order : null }}" required>
    </div>
</div>
<div class="flex flex-col space-y-1 w-full">
    <label class="font-medium text-sm text-gray-600"
        for="menugroup_id">{{ trans('maintenance.admin.menuoption.group') }}</label>
    <select
        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full p-2.5"
        name="menugroup_id" id="menugroup_id" required>
        @foreach ($formData['cboMenuGroups'] as $key => $value)
            <option value="{{ $key }}"
                {{ isset($formData['model']) && $formData['model']->menugroup_id == $key ? 'selected' : null }}>
                {{ $value }}
            </option>
        @endforeach
    </select>
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
