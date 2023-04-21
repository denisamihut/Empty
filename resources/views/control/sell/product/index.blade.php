<div class="container" id="container">
    <div class="flex flex-col w-full space-y-6">
        <p class="text-4xl font-bold font-baloo">{{ __('maintenance.sell.products.title') }}</p>
    </div>
    <form id="formSell" method="POST">
        <div class="flex items-center justify-between w-full py-8 px-12 rounded-xl bg-white mt-3">
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">{{ $errors->first('error') }}</strong>
                </div>
            @endif
            <div class="flex flex-col w-1/2 space-y-6">
                <input type="text" name="search" id="search" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block p-2.5 mr-2 ml-2" placeholder="Search">
                <div class="flex flex-col w-full space-y-6 overflow-y-scroll" style="height: 340px;">
                    @foreach ($products as $product)
                        @include('control.sell.carditem', ['item' => $product, 'route' => 'sellproduct.addToCart', 'remove' => 'sellproduct.removeFromCart'])
                    @endforeach
                </div>
            </div>
            
            <div class="flex flex-col w-1/2 space-y-6">
                <div class="flex flex-col w-full space-y-6 overflow-y-scroll" style="height: 340px;">
                    <table class="table-auto w-full" id="tblProductsSelected">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">{{ __('maintenance.sell.products.name') }}</th>
                                <th class="px-4 py-2">{{ __('maintenance.sell.products.quantity') }}</th>
                                <th class="px-4 py-2">{{ __('maintenance.sell.products.subtotal') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartProducts as $key => $item)
                                <tr>
                                    <td class="border px-4 py-2">{{ $item['name'] }}</td>
                                    <td class="border px-4 py-2">
                                        <div style="display: flex">
                                            <input type="hidden" name="productId[]" value="{{ $key }}">
                                            <input type="hidden" name="price[]" value="{{ $item['price'] }}">
                                            <input type="hidden" name="subtotal[]" value="{{ $item['total'] }}">
                                            <input onchange="handleChangeQuantity({{ $key }})" type="number" name="quantity[]" id="quantity-{{ $key }}" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block p-2.5 mr-2 ml-2" value="{{ $item['quantity'] }}">
                                            <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="removeFromCart({{ $key }});">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="border px-4 py-2">{{ $item['total'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    <h1 class="font-bold text-xl mb-3 ml-1">Total</h1>
                    <input type="text" name="totalCart" id="totalCart" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 focus:outline-none block p-2.5 mr-2 ml-2 w-full" value="{{ $cartProducts->sum('total') }}" readonly>
                </div>
            </div>
        </div>
        <div class="items-center justify-between w-full py-8 px-12 rounded-xl bg-white mt-3">
            @include('control.sell.billing', ['store' => 'sellproduct.store', 'number' => $number])
            <div class="flex items-center justify-end space-x-5 py-3 w-full">
                <button class="px-5 py-2 rounded-lg bg-blue-corp text-white flex items-center space-x-2" id="btnGuardar"
                    onclick="save(event)">
                    <i class="far fa-save"></i>
                    <p>{{ __('maintenance.sell.pay') }}</p>
                </button>
            </div>
        </div>
    </form>
</div>
<script>

   
</script>
