@include('utils.errorDiv', ['entidad' => $formData['entidad']])
@include('utils.formCrud', [
    'entidad' => $formData['entidad'],
    'formData' => $formData,
    'method' => $formData['method'],
    'route' => $formData['route'],
    'model' => isset($formData['model']) ? $formData['model'] : null,
])
<input type="hidden" name="action" value="{{ $formData['action'] }}">
<input type="hidden" name="business_id" value="{{ $formData['businessId'] }}">
<input type="hidden" name="branch_id" value="{{ $formData['branchId'] }}">
<div class="callout callout-danger">
	<p class="text-danger">{{ trans('maintenance.admin.branch.isMain') }}</p>
</div>
<div class="form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 text-right">
		<button class="btn btn-danger btn-sm ml-1" id="btnGuardar" onclick="guardar('{{$formData['entidad']}}', this);">
			<i class="fa fa-save"></i>
			<span>{{$formData['boton']}}</span>
		</button>
		<button class="btn btn-default btn-sm" id="btnCancelar{{$formData['entidad']}}" onclick="cerrarModal((contadorModal - 1));">
			<i class="fa fa-undo"></i>
			<span>{{ trans('maintenance.utils.cancel') }}</span>
		</button>
	</div>
</div>
</form>
<script type="text/javascript">
	$(document).ready(function() {
		init(IDFORMMANTENIMIENTO+'{!! $formData['entidad'] !!}', 'M', '{!! $formData['entidad'] !!}');
		configurarAnchoModal('400');
	}); 
</script>