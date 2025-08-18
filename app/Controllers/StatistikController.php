<?php
namespace App\Controllers;

use Exception;

class StatistikController extends BaseController
{
    public function index()
    {
        $this->data['page_title'] = 'Statistik Kriminalitas';
        $this->data['breadcrumb'] = 'Statistik Kriminalitas';
        
        return view('statistik/index', $this->data);
    }
    
    // Halaman khusus untuk grafik
    public function chart()
    {
        $this->data['page_title'] = 'Grafik Statistik Kriminalitas';
        $this->data['breadcrumb'] = 'Grafik Statistik';
        
        return view('statistik/chart', $this->data);
    }
    
    // Halaman khusus untuk tabel
    public function tabel()
    {
        $this->data['page_title'] = 'Tabel Statistik Kriminalitas';
        $this->data['breadcrumb'] = 'Tabel Statistik';
        
        return view('statistik/tabel', $this->data);
    }
    
    // API untuk mendapatkan data statistik
    public function getData()
    {
        // Set header JSON
        $this->response->setContentType('application/json');
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type');
        
        // Simulasi data dari database
        $data = [
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data' => [
                [
                    'id' => 1,
                    'jenis' => 'Pencurian',
                    'lokasi' => 'Jakarta Pusat',
                    'tanggal' => '2024-01-15',
                    'status' => 'Selesai',
                    'tingkat' => 'Sedang'
                ],
                [
                    'id' => 2,
                    'jenis' => 'Perampokan',
                    'lokasi' => 'Jakarta Utara',
                    'tanggal' => '2024-01-16',
                    'status' => 'Proses',
                    'tingkat' => 'Tinggi'
                ],
                [
                    'id' => 3,
                    'jenis' => 'Penipuan',
                    'lokasi' => 'Jakarta Selatan',
                    'tanggal' => '2024-01-17',
                    'status' => 'Selesai',
                    'tingkat' => 'Rendah'
                ],
                [
                    'id' => 4,
                    'jenis' => 'Narkoba',
                    'lokasi' => 'Jakarta Timur',
                    'tanggal' => '2024-01-18',
                    'status' => 'Proses',
                    'tingkat' => 'Tinggi'
                ],
                [
                    'id' => 5,
                    'jenis' => 'Pencurian',
                    'lokasi' => 'Jakarta Barat',
                    'tanggal' => '2024-01-19',
                    'status' => 'Selesai',
                    'tingkat' => 'Sedang'
                ]
            ]
        ];
        
        return $this->response->setJSON($data);
    }
    
    // API untuk data chart
    public function getChartData()
    {
        // Set header JSON
        $this->response->setContentType('application/json');
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        
        $chartType = $this->request->getGet('type');
        
        // Validasi input
        if (empty($chartType)) {
            return $this->response->setJSON([
                'error' => 'Parameter type tidak ditemukan'
            ])->setStatusCode(400);
        }
        
        try {
            switch($chartType) {
                case 'line':
                    $data = [
                        'labels' => ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
                        'datasets' => [
                            [
                                'label' => 'Pencurian',
                                'data' => [45, 52, 38, 67, 43, 55],
                                'borderColor' => 'rgb(78, 115, 223)',
                                'backgroundColor' => 'rgba(78, 115, 223, 0.1)',
                                'tension' => 0.4,
                                'fill' => true
                            ],
                            [
                                'label' => 'Perampokan',
                                'data' => [12, 18, 15, 23, 19, 28],
                                'borderColor' => 'rgb(231, 74, 59)',
                                'backgroundColor' => 'rgba(231, 74, 59, 0.1)',
                                'tension' => 0.4,
                                'fill' => true
                            ],
                            [
                                'label' => 'Penipuan',
                                'data' => [8, 12, 10, 15, 14, 18],
                                'borderColor' => 'rgb(28, 200, 138)',
                                'backgroundColor' => 'rgba(28, 200, 138, 0.1)',
                                'tension' => 0.4,
                                'fill' => true
                            ]
                        ]
                    ];
                    break;
                
                case 'pie':
                    $data = [
                        'labels' => ['Pencurian', 'Perampokan', 'Penipuan', 'Narkoba'],
                        'datasets' => [
                            [
                                'label' => 'Jumlah Kasus',
                                'data' => [45, 25, 20, 10],
                                'backgroundColor' => [
                                    'rgba(78, 115, 223, 0.8)',
                                    'rgba(231, 74, 59, 0.8)',
                                    'rgba(28, 200, 138, 0.8)',
                                    'rgba(246, 194, 62, 0.8)'
                                ],
                                'borderColor' => [
                                    'rgb(78, 115, 223)',
                                    'rgb(231, 74, 59)',
                                    'rgb(28, 200, 138)',
                                    'rgb(246, 194, 62)'
                                ],
                                'borderWidth' => 2
                            ]
                        ]
                    ];
                    break;
                
                case 'bar':
                    $data = [
                        'labels' => ['Jakarta Pusat', 'Jakarta Utara', 'Jakarta Selatan', 'Jakarta Barat', 'Jakarta Timur'],
                        'datasets' => [
                            [
                                'label' => 'Jumlah Kasus',
                                'data' => [45, 32, 28, 35, 41],
                                'backgroundColor' => [
                                    'rgba(78, 115, 223, 0.8)',
                                    'rgba(28, 200, 138, 0.8)',
                                    'rgba(54, 185, 204, 0.8)',
                                    'rgba(246, 194, 62, 0.8)',
                                    'rgba(231, 74, 59, 0.8)'
                                ],
                                'borderColor' => [
                                    'rgb(78, 115, 223)',
                                    'rgb(28, 200, 138)',
                                    'rgb(54, 185, 204)',
                                    'rgb(246, 194, 62)',
                                    'rgb(231, 74, 59)'
                                ],
                                'borderWidth' => 2
                            ]
                        ]
                    ];
                    break;
                
                default:
                    return $this->response->setJSON([
                        'error' => 'Tipe chart tidak valid. Gunakan: line, pie, atau bar'
                    ])->setStatusCode(400);
            }
            
            // Log untuk debugging
            log_message('info', 'Chart data requested: ' . $chartType);
            
            return $this->response->setJSON($data);
            
        } catch (Exception $e) {
            log_message('error', 'Error in getChartData: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'error' => 'Terjadi kesalahan saat mengambil data chart'
            ])->setStatusCode(500);
        }
    }
    
    // Method untuk mendapatkan statistik ringkasan
    public function getSummary()
    {
        $this->response->setContentType('application/json');
        
        $summary = [
            'success' => true,
            'data' => [
                'total_cases' => 181,
                'monthly_cases' => 87,
                'highest_area' => 'Jakarta Pusat',
                'trend' => 'increasing',
                'last_updated' => date('Y-m-d H:i:s'),
                'case_types' => [
                    'Pencurian' => 45,
                    'Perampokan' => 25,
                    'Penipuan' => 20,
                    'Narkoba' => 10
                ]
            ]
        ];
        
        return $this->response->setJSON($summary);
    }
}