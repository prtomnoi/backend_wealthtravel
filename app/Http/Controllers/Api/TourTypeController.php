<?php

namespace App\Http\Controllers\Api;

use App\Models\TourType;
use App\Http\Resources\Api\TourTypeResource;
use App\Http\Controllers\Controller;

class TourTypeController extends Controller
{
    public function index()
    {
        $tourTypes = TourType::all();
        return TourTypeResource::collection($tourTypes);
    }

    public function show($id)
    {
        $tourType = TourType::findOrFail($id);
        return new TourTypeResource($tourType);
    }
}
