<?php
namespace App\Controllers;

class PetaController extends BaseController
{
    public function index()
    {
        $this->data['page_title'] = 'Peta Rawan Kriminalitas';
        $this->data['breadcrumb'] = 'Peta Rawan Kriminalitas';
        
        return view('peta/index', $this->data);
    }
    
    public function getMapData()
    {
        // Simulasi data GeoJSON untuk peta
        $geoData = [
            'type' => 'FeatureCollection',
            'features' => [
                [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [106.8456, -6.2088] // Jakarta
                    ],
                    'properties' => [
                        'name' => 'Lokasi Insiden 1',
                        'type' => 'Pencurian',
                        'date' => '2024-01-15',
                        'severity' => 'medium'
                    ]
                ],
                [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [106.8650, -6.1751]
                    ],
                    'properties' => [
                        'name' => 'Lokasi Insiden 2',
                        'type' => 'Perampokan',
                        'date' => '2024-01-16',
                        'severity' => 'high'
                    ]
                ]
            ]
        ];
        
        return $this->response->setJSON($geoData);
    }
}