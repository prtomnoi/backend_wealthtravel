<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductType;
use App\Http\Resources\Api\ProductTypeResource;
use App\Http\Controllers\Controller;

class ProductTypeController extends Controller
{
    public function index()
    {
        $productTypes = ProductType::all();
        return ProductTypeResource::collection($productTypes);
    }

    public function show($id)
    {
        $productType = ProductType::findOrFail($id);
        return new ProductTypeResource($productType);
    }
}
