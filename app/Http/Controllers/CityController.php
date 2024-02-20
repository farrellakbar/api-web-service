<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function get_city()
    {
        $get_city = City::all();
        return response()->json(['status' => 'success', 'messages' => 'Data kota berhasil didapat!', 'data' => $get_city], 200);
    }
    public function get_city_by_province($id)
    {
        $province = Province::where('code', $id)->first();

        if (!$province) {
            return response()->json(['status' => 'error', 'messages' => 'Kode provinsi tidak ditemukan'], 422);
        }
        $get_city = City::join('indonesia_provinces', 'indonesia_provinces.code', '=', 'indonesia_cities.province_code')
                        ->where('indonesia_cities.province_code',$id)
                        ->select('indonesia_provinces.name as nameProvince','indonesia_cities.name as nameCity', 'indonesia_cities.meta')
                        ->get();
        return response()->json(['status' => 'success', 'messages' => 'Data kota berhasil didapat!', 'data' => $get_city], 200);
    }
    public function store_city(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:indonesia_cities,code|max:10',
            'province_code' => 'required|max:7',
            'name' => 'required|max:255',
            'meta' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'messages' => $validator->errors()], 422);
        }
        $province = Province::find($request->province_code);

        if (!$province) {
            return response()->json(['status' => 'error', 'messages' => 'Kode provinsi tidak ditemukan'], 422);
        }
        $city = City::create($request->all());
        return response()->json(['status' => 'success', 'messages' => 'Data kota berhasil ditambah!', 'data' => $city], 200);
    }
    public function store_city_province(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'province_code' => 'required|unique:indonesia_provinces,code|max:10',
            'name_province' => 'required|max:255',
            'meta_province' => 'nullable',
            'code_city' => 'required|unique:indonesia_cities,code|max:10',
            'name_city' => 'required|max:255',
            'meta_city' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'messages' => $validator->errors()], 422);
        }

        $province = Province::create([
            'code' => $request->province_code,
            'name' => $request->name_province,
            'meta' => $request->meta_province,
        ]);

        $city = City::create([
            'code' => $request->code_city,
            'province_code' => $province->code,
            'name' => $request->name_city,
            'meta' => $request->meta_city,
        ]);
        $result = [$province, $city];

        return response()->json(['status' => 'success', 'messages' => 'Data kota provinsi berhasil ditambah!', 'data' => $result], 200);
    }
    public function update_city(Request $request, $id)
    {
        try{
            $validator = Validator::make($request->all(), [
                'code' => 'required|unique:indonesia_cities,code,' . $id . '|max:10',
                'province_code' => 'required|max:7',
                'name' => 'required|max:255',
                'meta' => 'nullable',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'messages' => $validator->errors()], 422);
            }
            $city = City::findOrFail($id);
            $city->update($request->all());
            return response()->json(['status' => 'success', 'messages' => 'Data kota berhasil diubah!', 'data' => $city], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'messages' => 'Data kota dengan ID ' . $id . ' tidak ditemukan.'], 404);
        }
    }
    public function delete_city($id)
    {
        try{
            $city = City::findOrFail($id);
            $city_old = $city;
            $city->delete();
            return response()->json(['status' => 'success', 'messages' => 'Data kota berhasil dihapus!', 'data' => $city_old], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'messages' => 'Data kota dengan ID ' . $id . ' tidak ditemukan.'], 404);
        }
    }
}
