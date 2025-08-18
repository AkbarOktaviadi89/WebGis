<?php
namespace App\Controllers;

class ApiController extends BaseController
{
    public function getGeoJson()
    {
        // Return GeoJSON data untuk layer peta
        $geojson = [
            'type' => 'FeatureCollection',
            'features' => []
        ];
        
        return $this->response->setJSON($geojson);
    }
    
    public function getMarkers()
    {
        // Return data marker untuk peta
        $markers = [
            [
                'lat' => -6.2088,
                'lng' => 106.8456,
                'title' => 'Jakarta Pusat',
                'incidents' => 45
            ]
        ];
        
        return $this->response->setJSON($markers);
    }
}