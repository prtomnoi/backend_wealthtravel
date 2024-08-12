<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Resources\Api\ProductResource;
use App\Http\Resources\Api\ProductCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->query('lang', 'en'); 
        $keyword = $request->query('search');
        $productType = $request->query('product_type');
        $status = $request->query('status');
        $perPage = $request->query('per_page', 10); 

        $query = Product::with('productType');

   
        if ($keyword) {
            $query->where('name->' . $lang, 'LIKE', "%{$keyword}%");
        }

        if ($productType) {
            $query->where('product_type_id', $productType);
        }

        if ($status !== null) {
            $query->where('status', $status);
        }

        $products = $query->paginate($perPage);

        return new ProductCollection($products, $lang);
    }

    public function show(Request $request, $id)
    {
        $lang = $request->query('lang', 'en'); 
        $product = Product::with('productType')->findOrFail($id);

        return new ProductResource($product, $lang);
    }
}
