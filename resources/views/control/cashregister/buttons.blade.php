
<div class="inline-flex rounded-md shadow-sm" role="group">
    <button {{ $status == 'close' ? "disabled" : null }} type="button" class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-900 bg-green-500 rounded-l-lg border border-gray-200 hover:bg-gray-100 hover:text-yellow-700 focus:z-10 {{ $status == 'close' ? "cursor-not-allowed" : null }}" onclick="modal('{{URL::route($ruta['create'])}}', '{{$titles['new']}}', this);">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
      {{ __('maintenance.control.new') }}
    </button>
    <button {{ $status == 'open' ? "disabled" : null }} type="button" class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-900 bg-cyan-500 border-t border-b border-gray-200 hover:bg-gray-100 hover:text-yellow-700 focus:z-10 {{ $status == 'open' ? "cursor-not-allowed" : null }}" onclick="modal('{{URL::route($ruta['maintenance'], ['action' => 'OPEN'])}}', '{{$titles['open']}}', this);">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        {{ __('maintenance.control.open') }}
    </button>
    <button {{ $status == 'close' ? "disabled" : null }} type="button" class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-900 bg-rose-600 border-t border-b border-gray-200 hover:bg-gray-100 hover:text-yellow-700 focus:z-10 {{ $status == 'close' ? "cursor-not-allowed" : null }}"  onclick="modal('{{URL::route($ruta['maintenance'], ['action' => 'CLOSE'])}}', '{{$titles['close']}}', this);">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
          {{ __('maintenance.control.close') }}
    </button>
    <a href="{{ URL::route($ruta['print'], ['type' => 'A4']) }}" target="_blank" role="button">
      <button type="button" class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-900 bg-orange-500 border-t border-b border-gray-200 hover:bg-gray-100 hover:text-yellow-700 focus:z-10">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            {{ __('maintenance.control.printA4') }}
      </button>
    </a>
    <a href="{{ URL::route($ruta['print'], ['type' => 'TICKET']) }}" role="button" target="_blank">
      <button type="button" class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-900 bg-fuchsia-500 rounded-r-md border border-gray-200 hover:bg-gray-100 hover:text-yellow-700 focus:z-10">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
      {{ __('maintenance.control.printTicket') }}
      </button>
    </a>
  </div>
  