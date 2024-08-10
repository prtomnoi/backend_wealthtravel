<?php
namespace App\Http\Controllers\Api;

use App\Models\Tour;
use App\Http\Resources\Api\TourResource;
use App\Http\Resources\Api\TourCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->query('lang', 'en'); 
        $tours = Tour::with(['city', 'tourType', 'AttachFile'])->get();

        return new TourCollection($tours, $lang);
    }

    public function show(Request $request, $id)
    {
        $lang = $request->query('lang', 'en'); 
        $tour = Tour::with(['city', 'tourType', 'AttachFile'])->findOrFail($id);

        return new TourResource($tour, $lang);
    }
}