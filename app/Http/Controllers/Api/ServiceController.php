<?php
namespace App\Http\Controllers\Api;

use App\Models\Service;
use App\Http\Resources\Api\ServiceResource;
use App\Http\Resources\Api\ServiceCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->query('lang', 'en'); // Default to 'en' if not provided
        $keyword = $request->query('search');
        $serviceType = $request->query('service_type');
        $status = $request->query('status');
        $perPage = $request->query('per_page', 10); // Default to 10 per page

        // Build the query
        $query = Service::with('serviceType');

        // Apply filters
        if ($keyword) {
            $query->where('title->' . $lang, 'LIKE', "%{$keyword}%")
                  ->orWhere('sub_desc->' . $lang, 'LIKE', "%{$keyword}%")
                  ->orWhere('desc->' . $lang, 'LIKE', "%{$keyword}%");
        }

        if ($serviceType) {
            $query->where('service_type_id', $serviceType);
        }

        if ($status !== null) {
            $query->where('status', $status);
        }

        // Paginate the results
        $services = $query->paginate($perPage);

        // Return the paginated collection
        return new ServiceCollection($services, $lang);
    }

    public function show(Request $request, $id)
    {
        $lang = $request->query('lang', 'en'); // Default to 'en' if not provided
        $service = Service::with('serviceType')->findOrFail($id);

        return new ServiceResource($service, $lang);
    }
}

