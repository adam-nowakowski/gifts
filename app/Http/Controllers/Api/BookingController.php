<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BookingController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return BookingResource::collection(Booking::with(['user', 'room'])->get());
    }

    public function store(BookingRequest $request): BookingResource
    {
        $booking = Booking::createReservation($request->validated());

        return new BookingResource($booking);
    }

    public function destroy(Booking $booking): Response
    {
        $booking->delete();

        return response()->noContent();
    }
}
