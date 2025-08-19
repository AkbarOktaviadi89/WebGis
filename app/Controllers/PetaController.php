<?php
namespace App\Controllers;

class PetaController extends BaseController
{
    public function index()
    {
        $this->data['page_title'] = 'Peta Rawan Kriminalitas Kota Bandung';
        $this->data['breadcrumb'] = 'Peta Rawan Kriminalitas';
        
        return view('peta/index', $this->data);
    }
    
    public function getMapData()
    {
        // Simulasi data GeoJSON untuk peta Bandung
        $geoData = [
            'type' => 'FeatureCollection',
            'features' => [
                [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [107.6191, -6.9175] // Bandung Utara
                    ],
                    'properties' => [
                        'name' => 'Bandung Utara - Pencurian',
                        'type' => 'Pencurian',
                        'date' => '2024-01-15',
                        'severity' => 'medium',
                        'location' => 'Bandung Utara',
                        'count' => 38
                    ]
                ],
                [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [107.6098, -6.8915] // Cimahi
                    ],
                    'properties' => [
                        'name' => 'Cimahi - Perampokan',
                        'type' => 'Perampokan',
                        'date' => '2024-01-16',
                        'severity' => 'high',
                        'location' => 'Cimahi',
                        'count' => 20
                    ]
                ],
                [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [107.6191, -6.9575] // Bandung Selatan
                    ],
                    'properties' => [
                        'name' => 'Bandung Selatan - Penipuan',
                        'type' => 'Penipuan',
                        'date' => '2024-01-17',
                        'severity' => 'low',
                        'location' => 'Bandung Selatan',
                        'count' => 17
                    ]
                ],
                [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [107.6648, -6.9175] // Bandung Timur
                    ],
                    'properties' => [
                        'name' => 'Bandung Timur - Narkoba',
                        'type' => 'Narkoba',
                        'date' => '2024-01-18',
                        'severity' => 'high',
                        'location' => 'Bandung Timur',
                        'count' => 8
                    ]
                ],
                [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [107.5734, -6.9175] // Bandung Barat
                    ],
                    'properties' => [
                        'name' => 'Bandung Barat - Pencurian',
                        'type' => 'Pencurian',
                        'date' => '2024-01-19',
                        'severity' => 'medium',
                        'location' => 'Bandung Barat',
                        'count' => 25
                    ]
                ],
                [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [107.6098, -6.8995] // Coblong
                    ],
                    'properties' => [
                        'name' => 'Coblong - Penganiayaan',
                        'type' => 'Penganiayaan',
                        'date' => '2024-01-20',
                        'severity' => 'medium',
                        'location' => 'Coblong',
                        'count' => 12
                    ]
                ],
                [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [107.5951, -6.8705] // Sukasari
                    ],
                    'properties' => [
                        'name' => 'Sukasari - Penipuan',
                        'type' => 'Penipuan',
                        'date' => '2024-01-21',
                        'severity' => 'low',
                        'location' => 'Sukasari',
                        'count' => 9
                    ]
                ]
            ]
        ];
        
        return $this->response->setJSON($geoData);
    }
    
    public function getHeatmapData()
    {
        // Data untuk heatmap khusus Bandung
        $heatmapData = [
            'success' => true,
            'data' => [
                // Bandung Utara (hotspot)
                ['lat' => -6.9175, 'lng' => 107.6191, 'intensity' => 0.8],
                ['lat' => -6.9155, 'lng' => 107.6171, 'intensity' => 0.7],
                ['lat' => -6.9195, 'lng' => 107.6211, 'intensity' => 0.6],
                
                // Cimahi
                ['lat' => -6.8915, 'lng' => 107.6098, 'intensity' => 0.7],
                ['lat' => -6.8895, 'lng' => 107.6078, 'intensity' => 0.5],
                
                // Bandung Timur
                ['lat' => -6.9175, 'lng' => 107.6648, 'intensity' => 0.6],
                ['lat' => -6.9155, 'lng' => 107.6628, 'intensity' => 0.4],
                
                // Bandung Selatan
                ['lat' => -6.9575, 'lng' => 107.6191, 'intensity' => 0.5],
                ['lat' => -6.9555, 'lng' => 107.6171, 'intensity' => 0.3],
                
                // Bandung Barat
                ['lat' => -6.9175, 'lng' => 107.5734, 'intensity' => 0.6],
                ['lat' => -6.9155, 'lng' => 107.5714, 'intensity' => 0.4]
            ]
        ];
        
        return $this->response->setJSON($heatmapData);
    }
    
    public function addIncident()
    {
        // Handle POST request untuk menambah insiden baru
        $request = $this->request->getJSON();
        
        // Validasi data
        if (empty($request->type) || empty($request->location) || empty($request->date)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak lengkap'
            ])->setStatusCode(400);
        }
        
        // Simulasi penyimpanan ke database
        $newIncident = [
            'id' => rand(1000, 9999),
            'type' => $request->type,
            'location' => $request->location,
            'date' => $request->date,
            'description' => $request->description ?? '',
            'severity' => $request->severity ?? 'medium',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Log untuk debugging
        log_message('info', 'New incident added: ' . json_encode($newIncident));
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Insiden berhasil ditambahkan',
            'data' => $newIncident
        ]);
    }
}