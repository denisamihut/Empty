<?php

namespace App\Http\Controllers\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Services\BookingService;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    protected BookingService $service;
    protected int $businessId;
    protected int $branchId;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->businessId = session()->get('businessId');
            $this->branchId = session()->get('branchId');
            $this->service = new BookingService($this->businessId, $this->branchId);
            return $next($request);
        });
    }

    public function index()
    {
        try {
            $data = $this->service->getDataToCalendar();
            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => [],
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(BookingRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = [
                'dateto' => $request->dateto,
                'datefrom' => $request->datefrom,
                'room_id' => $request->room_id,
                'client_id' => $request->client_id,
                'notes' => $request->notes,
                'amount' => $request->amount,
                'user_id' => $request->user_id ?? null,
            ];
            $data = $this->service->storeBooking($data);
            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'data' => [],
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(BookingRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = [
                'dateto' => $request->dateto,
                'datefrom' => $request->datefrom,
                'room_id' => $request->room_id,
                'client_id' => $request->client_id,
                'notes' => $request->notes,
                'amount' => $request->amount,
                'user_id' => $request->user_id ?? null,
                'status' => $request->status,
            ];
            $data = $this->service->storeBooking($data);
            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'data' => [],
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->service->deleteBooking($request->id);
            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'data' => [],
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function rooms(Request $request)
    {
        try {
            $date_from = $request->date_from;
            $date_to = $request->date_to;
            $data = $this->service->getAvailableRooms($date_from, $date_to);
            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => [],
                'error' => $e->getMessage()
            ], 500);
        }
    }
}