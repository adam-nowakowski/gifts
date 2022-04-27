<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        return BookingResource::collection(Booking::with(['user', 'room'])->get());
    }

    public function store(BookingRequest $request)
    {
        $company = Booking::create($request->validated());

        return new BookingResource($company);
    }

    public function show(Booking $company)
    {
        return new BookingResource($company);
    }

    public function update(BookingRequest $request, Booking $company)
    {
        $company->update($request->validated());

        return new BookingResource($company);
    }

    public function destroy(Booking $company)
    {
        $company->delete();

        return response()->noContent();
    }
}
