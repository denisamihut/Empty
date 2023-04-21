@include('utils.errordiv', ['entidad' => $formData['entidad']])
@include('utils.formcrud', [
    'entidad' => $formData['entidad'],
    'formData' => $formData,
    'method' => $formData['method'],
    'route' => $formData['route'],
    'model' => isset($formData['model']) ? $formData['model'] : null,
])
<input type="hidden" name="business_id" value="{{ $formData['businessId'] }}">
<div class="flex space-x-6">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="name">{{ trans('maintenance.admin.user.name') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="name" id="name"
            value="{{ isset($formData['model']) ? $formData['model']->name : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="usertype_id">{{ trans('maintenance.admin.user.usertype') }}</label>
        <select class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" name="usertype_id" id="usertype_id" required>
            @foreach ($formData['cboUserTypes'] as $key => $value)
                <option value="{{ $key }}" {{ isset($formData['model']) && $formData['model']->usertype_id == $key ? 'selected' : null }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="flex space-x-6 mt-3">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="email">{{ trans('maintenance.admin.user.email') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="email" id="email"
            value="{{ isset($formData['model']) ? $formData['model']->email : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="password">{{ trans('maintenance.admin.user.password') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="password" name="password" id="password"
            value="" required>
    </div>
</div>
<div class="flex space-x-6 mt-3">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="people_id">{{ trans('maintenance.admin.user.person') }}</label>
        <select class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" name="people_id" id="people_id">
            @foreach ($formData['cboUserTypes'] as $key => $value)
                <option value="{{ $key }}" {{ isset($formData['model']) && $formData['model']->people_id == $key ? 'selected' : null }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="flex space-x-6 mt-3">
    @php
        if (isset($formData['model'])) {
            $branches_id = [];
            $branches = $formData['model']->branches;
            foreach ($branches as $branch) {
                array_push($branches_id, $branch->id);
            }
        }
    @endphp
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="cashbox_id">{{ trans('maintenance.admin.user.cashbox') }}</label>
        <select class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" name="cashbox_id" id="cashbox_id" required>
            @foreach ($formData['cboCashboxes'] as $key => $value)
                <option value="{{ $key }}" {{ isset($formData['model']) && $formData['model']->cashbox_id == $key ? 'selected' : null }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="branch_id">{{ trans('maintenance.admin.user.branch') }}</label>
        <select class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" name="branch_id[]" id="branch_id" required multiple>
            @foreach ($formData['cboBranches'] as $key => $value)
                <option value="{{ $key }}" {{ isset($formData['model']) && in_array($key,  $branches_id) ? 'selected' : null }}>{{ $value }}</option>
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
