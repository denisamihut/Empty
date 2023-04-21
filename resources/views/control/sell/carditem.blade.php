<div class="flex items center justify-between w-full py-8 px-12 rounded-xl bg-white">
    <div class="flex flex-col w-1/2 space-y-6">
        <p class=" font-semibold">{{ $item->name }}</p>
        <p>{{ $item->sale_price }}</p>
    </div>
    <div class="flex flex-col w-1/2 space-y-6">
        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="addToCart('{{ $item->id }}');">{{ __('maintenance.sell.add') }}</button>
    </div>
</div>
<script>
    function addToCart(id){
        var url = '{{ route($route, ':id') }}';
        url = url.replace(':id', id);
        postToCart(id);
    }

    function handleChangeQuantity(id){
        var value = document.getElementById("quantity-"+id).value;
        if(value <= 0){
            value = 1;
        }
        var params = {
            quantity: value
        };
        postToCart(id, params);
    }

    function removeFromCart(id){
        var url = '{{ route($remove, ':id') }}';
        url = url.replace(':id', id);
        var axiosConfig = {
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        }
        var data = axios.post(url, axiosConfig).then(function (response) {
            if(response.data.success){
                var cart = response.data.cart;
                addToTable(cart);
                Intranet.notificaciones(response.data.message, "Realizado!" , "success");
            }
        }).catch(function (error) {
            Intranet.notificaciones(response.data.message, "Error!" , "error");
        });
    }

    function postToCart(id, params = null){
        var url = '{{ route($route, ':id') }}';
        url = url.replace(':id', id);
        var axiosConfig = {
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        }
        var data = axios.post(url, params, axiosConfig).then(function (response) {
            if(response.data.success){
                var cart = response.data.cart;
                addToTable(cart);
                Intranet.notificaciones(response.data.message, "Realizado!" , "success");
            }
        }).catch(function (error) {
            var message = error.response.data.message;
            Intranet.notificaciones(message, "Error!" , "error");
        });
    }

    function addToTable(cart){
        var table = document.getElementById("tblProductsSelected");
        var totalCart = document.getElementById("totalCart");
        var rowCount = table.rows.length;
        for (var x=rowCount-1; x>0; x--) {
            table.deleteRow(x);
        }
        var total = 0;
        Object.keys(cart).forEach(function(key){
            var row = table.insertRow(1);
            total += cart[key].total;
            row.innerHTML = insertDataToRow(cart[key].name, cart[key].quantity, cart[key].total, key, cart[key].price);
        });
        totalCart.value = total;
        handleChangeTotalAmount();
    }

    function insertDataToRow(name, quantity, total, key, price){
        return "<tr><td class='border px-4 py-2'>"+name+"</td><td class='border px-4 py-2'><div style='display: flex'><input type='hidden' name='productId[]' value='"+key+"'><input type='hidden' name='price[]' value='"+price+"'><input type='hidden' name='subtotal[]' value='"+total+"'><input onchange='handleChangeQuantity("+key+")' type='number' name='quantity[]' id='quantity-"+key+"' class='border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block p-2.5 mr-2 ml-2' value='"+quantity+"'><button type='button' class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded' onclick='removeFromCart("+key+");'><i class='fas fa-trash'></i></button></div></td><td class='border px-4 py-2'>"+total+"</td></tr>";
    }

</script>