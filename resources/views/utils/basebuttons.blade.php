<button class="btn" onclick="modal('{{URL::route($ruta['edit'], array($id, 'listagain'=>'SI', 'params' => $params1 ?? null))}}', '{{$titulo_modificar}}', this);" >
    <i style="color: blue" class="fa fa-pen-alt"></i>
</button>
<button class="btn"  onclick="modal('{{URL::route($ruta['delete'], array($id, 'listagain'=>'SI', 'params' => $params2 ?? null))}}', '{{$titulo_eliminar}}', this);">
    <i style="color: red" class="fas fa-trash"></i>
</button>