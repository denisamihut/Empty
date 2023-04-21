<aside class="sticky top-0 left-0 bottom-0 h-screen overflow-x-hidden flex flex-col flex-none w-[17rem] bg-white pl-4 pr-3 py-4">
    <div class="flex items-center justify-center py-10">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('img/logo.png') }}" class="w-36" alt="Logo Yachay Wasi">
        </a>
    </div>
    <hr class="my-3">
    <div class="py-2 flex flex-col space-y-3 overflow-y-scroll">
        <div class="flex flex-col">
            <a href="{{ route('dashboard') }}" class="flex py-2.5 px-3.5 items-center group hover:bg-blue-corp rounded-md cursor-pointer w-full">
                <div class="flex items-center justify-between w-full text-sm group-hover:text-white text-gray-600">
                    <div class="flex items-center space-x-2">
                        <div class="w-5">
                            <i class="fa-solid fa-house"></i>
                        </div>
                        <p class="font-bold">
                            Inicio
                        </p>
                    </div>
                </div>
            </a>
        </div>
        <div class="flex flex-col">
            <a  onclick="cargarRuta('{{ URL::to('management') }}', 'main-container')" href="#" class="flex py-2.5 px-3.5 items-center group hover:bg-blue-corp rounded-md cursor-pointer w-full">
                <div class="flex items-center justify-between w-full text-sm group-hover:text-white text-gray-600">
                    <div class="flex items-center space-x-2">
                        <div class="w-5">
                            <i class="fa-solid fa-hotel"></i>
                        </div>
                        <p class="font-bold">
                            Habitaciones
                        </p>
                    </div>
                </div>
            </a>
        </div>
        <div class="flex flex-col">
            <a href="#" onclick="cargarRuta('{{ URL::to('cashregister') }}', 'main-container')" class="flex py-2.5 px-3.5 items-center group hover:bg-blue-corp rounded-md cursor-pointer w-full">
                <div class="flex items-center justify-between w-full text-sm group-hover:text-white text-gray-600">
                    <div class="flex items-center space-x-2">
                        <div class="w-5">
                            <i class="fas fa-cash-register"></i>
                        </div>
                        <p class="font-bold">
                            Caja
                        </p>
                    </div>
                </div>
            </a>
        </div>
        @foreach ($options as $key=>$item)
        @include('layouts.aside.item', ["item"=>$item])
        @endforeach
    </div>
</aside>
