<button onclick="cargarRuta('{{URL::route($routes['create'], ['status'=>$room['status'], 'id' => $room['id']])}}', 'main-container');" type="button" class="text-black bg-white hover:bg-white-800 focus:ring-4 focus:outline-none focus:ring-white-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-white-600 dark:hover:bg-white-700 dark:focus:ring-white-800">
  <i class="{{ $room['iconActionButton'] }} mr-2"></i>
  {{ $room['textActionButton'] }}
</button>