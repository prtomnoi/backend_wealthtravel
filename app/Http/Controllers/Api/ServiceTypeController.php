<?php

namespace App\Http\Controllers\Api;

use App\Models\ServiceType;
use App\Http\Resources\Api\ServiceTypeResource;
use App\Http\Controllers\Controller;

class ServiceTypeController extends Controller
{
    public function index()
    {
        $serviceTypes = ServiceType::all();
        return ServiceTypeResource::collection($serviceTypes);
    }

    public function show($id)
    {
        $serviceType = ServiceType::findOrFail($id);
        return new ServiceTypeResource($serviceType);
    }
}
