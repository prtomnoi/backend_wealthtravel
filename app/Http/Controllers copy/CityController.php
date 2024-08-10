<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models as Models;

class CityController extends Controller
{
    public function cityByContry(Request $request, $iso)
    {
        try {
            $main = Models\City::select('id', 'city')->where('iso3', $iso)->get();
            $res = [
                'code' => 200,
                'message' => 'fetch data success.',
                'error' => null,
                'data' => $main,
            ];
            return response()->json($res);
        } catch (\Throwable $e)
        {
            $res = [
                'code' => 500,
                'message' => 'Cannot delete value.',
                'error' => $e->getMessage(),
            ];
            return response()->json($res);
        }
    }
}
