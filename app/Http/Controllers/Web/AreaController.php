<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AreaController extends Controller
{
    private $apiBase = "https://slir2.top/api/regionstore/linkage";

    public function get(Request $request){
        return response()->json([]);
    }

    public function getCity(Request $request){
        $response = Http::timeout(5)->get($this->apiBase);
        if ($response->successful()) {
            $data = $response->json()["data"] ?? [];
            return response()->json($data);
        }
        return response()->json([]);
    }

    public function getCounty(Request $request){
        $cityName = $request->city_name ? trim($request->city_name) : "";
        if (!$cityName) return response()->json([]);

        $resp = Http::timeout(5)->get($this->apiBase);
        if (!$resp->successful()) return response()->json([]);
        $cities = $resp->json()["data"] ?? [];
        $cityId = null;
        foreach ($cities as $c) {
            if ($c["name"] === $cityName) { $cityId = $c["id"]; break; }
        }
        if (!$cityId) return response()->json([]);

        $resp2 = Http::timeout(5)->get($this->apiBase, ["city_id" => $cityId]);
        if ($resp2->successful()) {
            return response()->json($resp2->json()["data"] ?? []);
        }
        return response()->json([]);
    }

    public function getRoad(Request $request){
        $cityName = $request->city_name ? trim($request->city_name) : "";
        $countyName = $request->county_name ? trim($request->county_name) : "";
        if (!$cityName || !$countyName) return response()->json([]);

        $resp = Http::timeout(5)->get($this->apiBase);
        if (!$resp->successful()) return response()->json([]);
        $cities = $resp->json()["data"] ?? [];
        $cityId = null;
        foreach ($cities as $c) {
            if ($c["name"] === $cityName) { $cityId = $c["id"]; break; }
        }
        if (!$cityId) return response()->json([]);

        $resp2 = Http::timeout(5)->get($this->apiBase, ["city_id" => $cityId]);
        if (!$resp2->successful()) return response()->json([]);
        $districts = $resp2->json()["data"] ?? [];
        $districtId = null;
        foreach ($districts as $d) {
            if ($d["name"] === $countyName) { $districtId = $d["id"]; break; }
        }
        if (!$districtId) return response()->json([]);

        $resp3 = Http::timeout(5)->get($this->apiBase, ["city_id" => $cityId, "district_id" => $districtId]);
        if ($resp3->successful()) {
            return response()->json($resp3->json()["data"] ?? []);
        }
        return response()->json([]);
    }

    public function getShop(Request $request){
        $cityName = $request->city_name ? trim($request->city_name) : "";
        $countyName = $request->county_name ? trim($request->county_name) : "";
        $roadName = $request->road_name ? trim($request->road_name) : "";
        if (!$cityName || !$countyName || !$roadName) return response("");

        // Get city ID
        $resp = Http::timeout(5)->get($this->apiBase);
        if (!$resp->successful()) return response("");
        $cities = $resp->json()["data"] ?? [];
        $cityId = null;
        foreach ($cities as $c) {
            if ($c["name"] === $cityName) { $cityId = $c["id"]; break; }
        }
        if (!$cityId) return response("");

        // Get district ID
        $resp2 = Http::timeout(5)->get($this->apiBase, ["city_id" => $cityId]);
        if (!$resp2->successful()) return response("");
        $districts = $resp2->json()["data"] ?? [];
        $districtId = null;
        foreach ($districts as $d) {
            if ($d["name"] === $countyName) { $districtId = $d["id"]; break; }
        }
        if (!$districtId) return response("");

        // Get road ID
        $resp3 = Http::timeout(5)->get($this->apiBase, ["city_id" => $cityId, "district_id" => $districtId]);
        if (!$resp3->successful()) return response("");
        $roads = $resp3->json()["data"] ?? [];
        $roadId = null;
        foreach ($roads as $r) {
            if ($r["name"] === $roadName) { $roadId = $r["id"]; break; }
        }
        if (!$roadId) return response("");

        // Get stores
        $resp4 = Http::timeout(5)->get($this->apiBase, [
            "city_id" => $cityId,
            "district_id" => $districtId,
            "road_id" => $roadId
        ]);
        if (!$resp4->successful()) return response("");

        $stores = $resp4->json()["data"] ?? [];

        // Format store data for the view
        $data = [];
        foreach ($stores as $s) {
            $data[] = [
                "shop_no" => $s["store_no"] ?? "",
                "shop_name" => $s["store_name"] ?? "",
                "shop_address" => $s["address"] ?? "",
            ];
        }

        return view("web.widgets.shopping-store-item", compact("data"))->render();
    }
}
