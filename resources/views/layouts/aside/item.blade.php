@if ($item["menuoption"]!=[])
<div class="flex flex-col">
    <button type="button" class="flex py-2.5 px-3.5 items-center group hover:bg-blue-corp rounded-md cursor-pointer w-full" aria-controls="dropdown-{{$item["id"]}}" data-collapse-toggle="dropdown-{{$item["id"]}}" aria-expanded="false">
        <div class="flex items-center justify-between w-full text-sm group-hover:text-white text-gray-600">
            <div class="flex items-center space-x-2">
                <div class="w-5">
                    <i class="fa-solid {{$item["icon"]}}"></i>
                </div>
                <p class="font-bold" sidebar-toggle-item>
                    {{$item["name"]}}
                </p>
            </div>
            @if ($item["menuoption"]!=[])
            <i class="right fas fa-angle-down"></i>
            @endif
        </div>
    </button>
    <ul id="dropdown-{{$item["id"]}}" class="hidden">
        @foreach ($item["menuoption"] as $opcion)
        <li class="flex py-0.5 pl-7 pr-3 items-center w-full">
            <a href="#" onclick="cargarRuta('{{URL::to($opcion['link'])}}', 'main-container');" class="flex items-center py-1.5 px-3.5 hover:bg-gray-100 rounded-md w-full space-x-2 text-sm text-gray-500 {{getMenuActivo($opcion["link"])}}">
                <div class="w-5">
                    <i class="fa-solid {{$opcion["icon"]}}"></i>
                </div>
                <p class="font-medium">
                    {{$opcion["name"]}}
                </p>
            </a>
        </li>
        @endforeach
    </ul>
</div>
@endif
