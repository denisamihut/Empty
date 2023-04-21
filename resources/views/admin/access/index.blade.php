<div class="" id="container">
    <div class="flex flex-col w-full space-y-6">
        <p class="text-4xl font-bold font-baloo mb-3">Accesos</p>
    </div>
    <div class="flex items-center justify-between w-full py-8 px-12 rounded-xl bg-white">
        @csrf
            <table id="example1" class="w-full text-base font-medium text-left text-gray-500">
                <thead>
                    <tr>
                        <th class="text-gray-900">Tipos de Usuario</th>
                        @foreach ($tipousuarios as $id => $name)
                        <th class="text-center text-gray-900">{{$name}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="border-b border-gray-300">
                    @foreach ($grupomenus as $key=>$grupomenu)
                    <tr>
                        <td class="py-3 px-4 text-gray-900"><i
                                class="fa fa-arrows-alt p-2 text-indigo-700"></i>{{$grupomenu["name"]}}</td>
                        @foreach ($tipousuarios as $id=>$name)

                        @endforeach
                    </tr>
                    @foreach ($grupomenu["menuoption"] as $key => $opcion)
                    <tr class="border-b">
                        <td style="padding-left: 50px" class="pl-40 text-gray-900"><i
                                class="fa fa-arrow-right p-2 text-blue-700"></i>{{ $opcion["name"] }}</td>
                        @foreach ($tipousuarios as $id => $name)
                        <td class="text-center">
                            <input type="checkbox" class="acceso" name="acceso[]"
                                data-opcionid={{$opcion["id"]}} value="{{$id}}"
                                {{in_array($id, array_column($opcionmenus[$opcion["id"]], "id"))? "checked" : ""}}>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.acceso').on('change', function() {
            var data = {
                menuoption_id: $(this).data('opcionid'),
                usertype_id: $(this).val(),
                _token: $('input[name=_token]').val()
            };
            if ($(this).is(':checked')) {
                data.estado = 1
            } else {
                data.estado = 0
            }
            ajaxRequest('access', data);
        });
        function ajaxRequest(url, data) {
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(respuesta) {
                    Intranet.notificaciones(respuesta.respuesta, 'Prueba', 'success');
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }
    });
</script>