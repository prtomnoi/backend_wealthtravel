<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models as Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $data = Models\Tour::orderByDesc('id')->paginate(10);
        return view('admin.tour.index', compact('data'));
    }

    public function show(Request $request, $id) {}

    public function create(Request $request)
    {
        $tourType = Models\TourType::all();
        $contry = Models\Country::select('alpha_3', 'name')->get();
        return view('admin.tour.create', compact('tourType', 'contry'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => ['required'],
            'sub_desc' => ['sometimes'],
            'desc' => ['sometimes'],
            'city_id' => ['sometimes'],
            'start_date' => ['sometimes'],
            'end_date' => ['sometimes'],
            'duration' => ['sometimes'],
            'lange' => ['sometimes'],
            'type' => ['required'],
            'price' => ['sometimes'],
        ]);
        try {
            DB::beginTransaction();
            $main = new Models\Tour();
            $main->setTranslation('title', $request->input('lange', 'en'), $validate['title']);
            $main->setTranslation('sub_desc', $request->input('lange', 'en'), $request->input('sub_desc', ''));
            $main->setTranslation('desc', $request->input('lange', 'en'), $request->input('desc', ''));
            $main->start_date = $request->input('start_date', now());
            $main->end_date = $request->input('end_date', now());
            $main->tour_type_id = $request->input('type');
            $main->duration = $request->input('duration', 1);
            $main->price = $this->getAmount($request->input('price', 0));
            $main->city_id = $request->input('city_id');
            $main->save();
            if ($request->hasFile('uploadImage')) {
                foreach ($request->uploadImage as $key => $item) {
                    $filename = uniqid() . "_" . time() . "." . $item->getClientOriginalExtension();
                    Models\Attachment::create([
                        "name" => $filename,
                        "path" => "tour/" . $filename,
                        "type" => $item->getClientOriginalExtension(),
                        "group" => "tour",
                        "ref_id" => $main->id,
                    ]);
                    $item->storeAs("tour", $filename, "local_public");
                }
            }
            // pdf
            if ($request->hasFile('uploadPdf')) {
                $filename = uniqid() . "_" . time() . "." . $request->uploadPdf->getClientOriginalExtension();
                Models\Attachment::create([
                    "name" => $filename,
                    "path" => "tour/" . $filename,
                    "type" => $request->uploadPdf->getClientOriginalExtension(),
                    "group" => "tour",
                    "ref_id" => $main->id,
                ]);
                $request->uploadPdf->storeAs("tour", $filename, "local_public");
            }
            DB::commit();
            return redirect()->route('tour.index')->with('success', 'Insert value success.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Cannot insert value.', $e->getMessage()]);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $main = Models\Tour::find($id);
            $tourType = Models\TourType::all();
            $contry = Models\Country::select('alpha_3', 'name')->get();
            $city = Models\City::select('id', 'city', 'iso3')->where('iso3', $main->city?->iso3)->get();
            // dd($main->city?->iso3);
            return view('admin.tour.edit', compact('main', 'tourType', 'contry', 'city'));
        } catch (\Throwable $e) {
            return back()->withErrors(['cannot open edit', $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'title' => ['required'],
            'sub_desc' => ['sometimes'],
            'desc' => ['sometimes'],
            'city_id' => ['sometimes'],
            'start_date' => ['sometimes'],
            'end_date' => ['sometimes'],
            'duration' => ['sometimes'],
            'lange' => ['sometimes'],
            'type' => ['sometimes'],
            'price' => ['sometimes'],
            'uploadPdf' => ['sometimes', 'mimes:pdf', 'max:5000'],
        ]);
        try {
            DB::beginTransaction();
            $main = Models\Tour::find($id);
            $main->setTranslation('title', $request->input('lange', 'en'), $request->input('title', $main->title));
            $main->setTranslation('sub_desc', $request->input('lange', 'en'), $request->input('sub_desc', $main->sub_desc));
            $main->setTranslation('desc', $request->input('lange', 'en'), $request->input('desc', $main->desc));
            $main->start_date = $request->input('start_date', $main->start_date);
            $main->end_date = $request->input('end_date', $main->end_date);
            $main->tour_type_id = $request->input('type', $main->tour_type_id);
            $main->duration = $request->input('duration', $main->duration);
            $main->price = $this->getAmount($request->input('price', $main->price));
            $main->city_id = $request->input('city_id', $main->city_id);
            $main->save();
            // image
            if ($request->hasFile('uploadImage')) {
                foreach ($request->uploadImage as $key => $item) {
                    $filename = uniqid() . "_" . time() . "." . $item->getClientOriginalExtension();
                    Models\Attachment::create([
                        "name" => $filename,
                        "path" => "tour/" . $filename,
                        "type" => $item->getClientOriginalExtension(),
                        "group" => "tour",
                        "ref_id" => $main->id,
                    ]);
                    $item->storeAs("tour", $filename, "local_public");
                }
            }
            // pdf
            if ($request->hasFile('uploadPdf')) {
                if($main->AttachFilePdf){
                    foreach ($main->AttachFilePdf as $key => $value) {
                        File::delete(public_path('app/'. $value?->path));
                        $value->delete();
                    }
                }
                $filename = uniqid() . "_" . time() . "." . $request->uploadPdf->getClientOriginalExtension();
                Models\Attachment::create([
                    "name" => $filename,
                    "path" => "tour/" . $filename,
                    "type" => $request->uploadPdf->getClientOriginalExtension(),
                    "group" => "tour",
                    "ref_id" => $main->id,
                ]);
                $request->uploadPdf->storeAs("tour", $filename, "local_public");
            }
            DB::commit();
            return redirect()->route('tour.index')->with('success', 'Update value success.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Cannot update value.', $e->getMessage()]);
        }
    }

    public function destroy(Request $request, $id)
    {
        // $validate = $request->validate([
        //     'status' => "sometimes",
        // ]);
        try {
            DB::beginTransaction();
            $main = Models\Tour::find($id);
            // $main->update($validate);
            $main->delete();
            DB::commit();
            $res = [
                'code' => 200,
                'message' => 'Delete value success.',
                'error' => null,
            ];
            return response()->json($res);
        } catch (\Exception $e) {
            DB::rollBack();
            $res = [
                'code' => 200,
                'message' => 'Cannot delete value.',
                'error' => $e->getMessage(),
            ];
            return response()->json($res);
        }
    }

    public function downloadPdf(Request $request ,$id)
    {
        $main = Models\Tour::find($id);
        return response()->download(public_path('app/'. $main->AttachFilePdf[0]?->path));
    }
}
