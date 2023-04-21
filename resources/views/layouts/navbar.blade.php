<nav class="bg-white py-4 px-10 w-full shadow-lg sticky top-0 z-40">
    <div class="flex items-center justify-end space-x-10">
        <div class="text-xl">
            <i class="fa-regular fa-bell"></i>
        </div>
        <button id="dropdownNavbar" data-dropdown-toggle="dropdown" data-dropdown-placement="bottom-start">
            <img src="{{ asset('img/logo.png') }}" class="w-9 h-9 rounded-full" alt="User Image">
        </button>
    </div>
    <div id="dropdown" class="hidden z-50 bg-white rounded divide-y divide-gray-100 shadow">
        <ul class="py-1 text-gray-700" aria-labelledby="dropdownNavbar">
            <li>
                <a href="#" class="block py-2 px-4 hover:bg-gray-100">Perfil</a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}" class="cursor-pointer">
                    @csrf
                    <a :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();" class="block py-2 px-4 hover:bg-gray-100">Cerrar sesión</a>
                </form>
            </li>
        </ul>
    </div>
</nav>
