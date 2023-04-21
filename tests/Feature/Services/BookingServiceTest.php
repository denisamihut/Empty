<?php

namespace Tests\Feature\Services;

use App\Http\Services\BookingService;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingServiceTest extends TestCase
{
    private BookingService $bookingService;
    private int $branch_id = 1;
    private int $business_id = 1;
    private Booking $booking;

    public function setUp(): void
    {
        parent::setUp();
        $this->booking = new Booking();
        $this->bookingService = new BookingService($this->booking, $this->branch_id, $this->business_id);
    }

    public function testGetDataToCalendar()
    {
        $data = $this->bookingService->getDataToCalendar();
        dd($data);
        $this->assertIsNotArray($data);
    }
}