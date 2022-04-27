<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function index()
    {
        return ReservationResource::collection(Reservation::all());
    }

    public function store(ReservationRequest $request)
    {
        $company = Reservation::create($request->validated());

        return new ReservationResource($company);
    }

    public function show(Reservation $company)
    {
        return new ReservationResource($company);
    }

    public function update(ReservationRequest $request, Reservation $company)
    {
        $company->update($request->validated());

        return new ReservationResource($company);
    }

    public function destroy(Reservation $company)
    {
        $company->delete();

        return response()->noContent();
    }
}
