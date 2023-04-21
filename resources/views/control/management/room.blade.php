<div class="p-6 max-w-sm {{ $room->color }} rounded-lg border border-gray-200 shadow-md">
    @include('control.management.badges', ['room' => $room])
    <a href="#">
        <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white mt-2">
            <i class=" fas fa-hotel"></i>
            {{ $room['name'] }}
        </h5>
    </a>
    <hr>
    <p class="mb-3 text-gray-900 dark:text-white font-semibold mt-2">{{ $room['roomType']['name'] . ' -  S/. ' .  $room['roomType']['price']}}</p>
    <div class="flex justify-center">
        @include('control.management.actions', ['room' => $room, 'routes' => $routes])
    </div>
</div>