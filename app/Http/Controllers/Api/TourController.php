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
        $keyword = $request->query('keyword');
        $city = $request->query('city');
        $country = $request->query('country');
        $perPage = $request->query('per_page', 10);

        $query = Tour::with(['city', 'tourType', 'AttachFile']);

        if ($keyword) {
            $query->where('title->' . $lang, 'LIKE', "%{$keyword}%")
                  ->orWhere('sub_desc->' . $lang, 'LIKE', "%{$keyword}%")
                  ->orWhere('desc->' . $lang, 'LIKE', "%{$keyword}%");
        }

        if ($city) {
            $query->whereHas('city', function ($q) use ($city) {
                $q->where('name', 'LIKE', "%{$city}%");
            });
        }

        if ($country) {
            $query->whereHas('city.country', function ($q) use ($country) {
                $q->where('name', 'LIKE', "%{$country}%");
            });
        }
        $tours = $query->paginate($perPage);
        return new TourCollection($tours, $lang);
    }

    public function show(Request $request, $id)
    {
        $lang = $request->query('lang', 'en'); 
        $tour = Tour::with(['city', 'tourType', 'AttachFile'])->findOrFail($id);

        return new TourResource($tour, $lang);
    }
}