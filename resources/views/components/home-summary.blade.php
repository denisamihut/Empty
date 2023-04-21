<div class="w-full relative z-10 bg-white rounded-lg flex overflow-hidden">
    <div class="bg-{{$item["color"]}} w-2"></div>
    <div class="flex flex-col items-start px-8 py-8 space-y-1.5">
        <p class="text-[#FDB82D] text-sm font-semibold uppercase">{{$item["title"]}}</p>
        <p class="text-xl font-medium">{{$item["content"]}}</p>
    </div>
    <div class="absolute inset-y-0 right-7 flex items-center text-3xl text-gray-500/20">
        <i class="fa-solid {{$item["icon"]}}"></i>
    </div>
</div>
