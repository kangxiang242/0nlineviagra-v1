<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class StoreSynchronizing
{
    protected string $guard;
    protected string $apiBase = 'https://slir2.top/api/regionstore/linkage';

    public function __construct(string $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Static factory - creates a new instance for the given guard.
     */
    public static function make(string $guard): self
    {
        return new self($guard);
    }

    /**
     * Get shops for the given city/county/street names.
     *
     * @param string $city   City name (e.g., 台北市)
     * @param string $county District name (e.g., 大安區)
     * @param string $street Road name (e.g., 忠孝東路四段)
     * @return array Array of shops with shop_no, shop_name, shop_address
     */
    public function getShop(string $city, string $county, string $street): array
    {
        try {
            // Step 1: Get all cities and find city_id
            $response = Http::timeout(10)->get($this->apiBase);
            if (!$response->successful()) {
                return [];
            }
            $cities = $response->json()['data'] ?? [];
            $cityId = null;
            foreach ($cities as $c) {
                if (($c['name'] ?? '') === $city) {
                    $cityId = $c['id'] ?? null;
                    break;
                }
            }
            if (!$cityId) return [];

            // Step 2: Get districts for this city
            $resp2 = Http::timeout(10)->get($this->apiBase, ['city_id' => $cityId]);
            if (!$resp2->successful()) return [];
            $districts = $resp2->json()['data'] ?? [];
            $districtId = null;
            foreach ($districts as $d) {
                if (($d['name'] ?? '') === $county) {
                    $districtId = $d['id'] ?? null;
                    break;
                }
            }
            if (!$districtId) return [];

            // Step 3: Get roads for this district
            $resp3 = Http::timeout(10)->get($this->apiBase, [
                'city_id' => $cityId,
                'district_id' => $districtId,
            ]);
            if (!$resp3->successful()) return [];
            $roads = $resp3->json()['data'] ?? [];
            $roadId = null;
            foreach ($roads as $r) {
                if (($r['name'] ?? '') === $street) {
                    $roadId = $r['id'] ?? null;
                    break;
                }
            }
            if (!$roadId) return [];

            // Step 4: Get stores for this road
            $resp4 = Http::timeout(10)->get($this->apiBase, [
                'city_id' => $cityId,
                'district_id' => $districtId,
                'road_id' => $roadId,
            ]);
            if (!$resp4->successful()) return [];

            $stores = $resp4->json()['data'] ?? [];

            // Format to expected structure
            // The store_id in the form comes from store_no (e.g., 282932, 260220)
            $result = [];
            foreach ($stores as $s) {
                $result[] = [
                    'shop_no' => $s['store_no'] ?? $s['id'] ?? '',
                    'shop_name' => $s['store_name'] ?? $s['name'] ?? '',
                    'shop_address' => $s['address'] ?? '',
                    'shop_type' => $s['shop_type'] ?? 0,
                ];
            }
            return $result;
        } catch (\Exception $e) {
            return [];
        }
    }
}
