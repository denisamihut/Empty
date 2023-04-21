<div class="bg-white flex rounded-lg overflow-hidden h-16">
    <div class="bg-blue-corp w-2 flex-none"></div>
    <div class="flex space-x-1 w-full text-sm">
        <div class="bg-slate-100 flex items-center px-4 w-56 shrink-0">
            <p class="truncate ">{{ $item["name"] }}</p>
        </div>
        <div class="bg-slate-100 flex items-center flex-none px-3">
            <img src="{{ asset("assets/$theme/dist/img/avatar5.png") }}" class="w-9 h-9 rounded-full" alt="User Image">
        </div>
        <div class="bg-blue-corp flex items-center justify-center px-4 w-full">
            <p class="text-white text-center">{{ $item["day"] }}</p>
        </div>
    </div>
</div>
