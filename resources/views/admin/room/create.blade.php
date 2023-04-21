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
        <label class="font-medium text-sm text-gray-600" for="name">{{ trans('maintenance.admin.room.name') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="name" id="name"
            value="{{ isset($formData['model']) ? $formData['model']->name : null }}" required>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="number">{{ trans('maintenance.admin.room.number') }}</label>
        <input class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" type="text" name="number" id="number"
            value="{{ isset($formData['model']) ? $formData['model']->number : null }}" required>
    </div>

</div>
<div class="flex space-x-6 mt-3">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600" for="status">{{ trans('maintenance.admin.room.status') }}</label>
        <select class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full px-4 py-2.5" name="status" id="status" required>
            @foreach ($formData['cboStatus'] as $key => $value)
                <option value="{{ $key }}" {{ isset($formData['model']) && $formData['model']->status == $key ? 'selected' : null }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600"
            for="room_type_id">{{ trans('maintenance.admin.room.type') }}</label>
        <select
            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full p-2.5"
            name="room_type_id" id="room_type_id" required>
            @foreach ($formData['cboRoomType'] as $key => $value)
                <option value="{{ $key }}"
                    {{ isset($formData['model']) && $formData['model']->room_type_id == $key ? 'selected' : null }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="flex space-x-6 mt-3">
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600"
            for="floor_id">{{ trans('maintenance.admin.room.floor') }}</label>
        <select
            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block w-full p-2.5"
            name="floor_id" id="floor_id" required>
            @foreach ($formData['cboFloor'] as $key => $value)
                <option value="{{ $key }}"
                    {{ isset($formData['model']) && $formData['model']->floor_id == $key ? 'selected' : null }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="flex flex-col space-y-1 w-full">
        <label class="font-medium text-sm text-gray-600"
            for="branch_id">{{ trans('maintenance.admin.room.branch') }}</label>
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
