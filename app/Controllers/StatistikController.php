<?php
namespace App\Controllers;

use Exception;

class StatistikController extends BaseController
{
    public function index()
    {
        $this->data['page_title'] = 'Statistik Kriminalitas Bandung';
        $this->data['breadcrumb'] = 'Statistik Kriminalitas';
        
        return view('statistik/index', $this->data);
    }
    
    // Halaman khusus untuk grafik
    public function chart()
    {
        $this->data['page_title'] = 'Grafik Statistik Kriminalitas Bandung';
        $this->data['breadcrumb'] = 'Grafik Statistik';
        
        return view('statistik/chart', $this->data);
    }
    
    // Halaman khusus untuk tabel
    public function tabel()
    {
        $this->data['page_title'] = 'Tabel Statistik Kriminalitas Bandung';
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
        
        // Simulasi data dari database - Data Bandung
        $data = [
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data' => [
                [
                    'id' => 1,
                    'jenis' => 'Pencurian',
                    'lokasi' => 'Bandung Utara',
                    'tanggal' => '2024-01-15',
                    'status' => 'Selesai',
                    'tingkat' => 'Sedang'
                ],
                [
                    'id' => 2,
                    'jenis' => 'Perampokan',
                    'lokasi' => 'Cimahi',
                    'tanggal' => '2024-01-16',
                    'status' => 'Proses',
                    'tingkat' => 'Tinggi'
                ],
                [
                    'id' => 3,
                    'jenis' => 'Penipuan',
                    'lokasi' => 'Bandung Selatan',
                    'tanggal' => '2024-01-17',
                    'status' => 'Selesai',
                    'tingkat' => 'Rendah'
                ],
                [
                    'id' => 4,
                    'jenis' => 'Narkoba',
                    'lokasi' => 'Bandung Timur',
                    'tanggal' => '2024-01-18',
                    'status' => 'Proses',
                    'tingkat' => 'Tinggi'
                ],
                [
                    'id' => 5,
                    'jenis' => 'Pencurian',
                    'lokasi' => 'Bandung Barat',
                    'tanggal' => '2024-01-19',
                    'status' => 'Selesai',
                    'tingkat' => 'Sedang'
                ],
                [
                    'id' => 6,
                    'jenis' => 'Penganiayaan',
                    'lokasi' => 'Coblong',
                    'tanggal' => '2024-01-20',
                    'status' => 'Proses',
                    'tingkat' => 'Sedang'
                ],
                [
                    'id' => 7,
                    'jenis' => 'Penipuan',
                    'lokasi' => 'Sukasari',
                    'tanggal' => '2024-01-21',
                    'status' => 'Selesai',
                    'tingkat' => 'Rendah'
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
                                'data' => [38, 45, 32, 58, 37, 48],
                                'borderColor' => 'rgb(78, 115, 223)',
                                'backgroundColor' => 'rgba(78, 115, 223, 0.1)',
                                'tension' => 0.4,
                                'fill' => true
                            ],
                            [
                                'label' => 'Perampokan',
                                'data' => [10, 15, 12, 19, 16, 23],
                                'borderColor' => 'rgb(231, 74, 59)',
                                'backgroundColor' => 'rgba(231, 74, 59, 0.1)',
                                'tension' => 0.4,
                                'fill' => true
                            ],
                            [
                                'label' => 'Penipuan',
                                'data' => [6, 10, 8, 12, 11, 15],
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
                        'labels' => ['Pencurian', 'Perampokan', 'Penipuan', 'Narkoba', 'Penganiayaan'],
                        'datasets' => [
                            [
                                'label' => 'Jumlah Kasus',
                                'data' => [38, 20, 17, 8, 12],
                                'backgroundColor' => [
                                    'rgba(78, 115, 223, 0.8)',
                                    'rgba(231, 74, 59, 0.8)',
                                    'rgba(28, 200, 138, 0.8)',
                                    'rgba(246, 194, 62, 0.8)',
                                    'rgba(156, 39, 176, 0.8)'
                                ],
                                'borderColor' => [
                                    'rgb(78, 115, 223)',
                                    'rgb(231, 74, 59)',
                                    'rgb(28, 200, 138)',
                                    'rgb(246, 194, 62)',
                                    'rgb(156, 39, 176)'
                                ],
                                'borderWidth' => 2
                            ]
                        ]
                    ];
                    break;
                
                case 'bar':
                    $data = [
                        'labels' => ['Bandung Utara', 'Bandung Selatan', 'Bandung Timur', 'Bandung Barat', 'Cimahi'],
                        'datasets' => [
                            [
                                'label' => 'Jumlah Kasus',
                                'data' => [38, 28, 25, 30, 35],
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
                'total_cases' => 156,
                'monthly_cases' => 74,
                'highest_area' => 'Bandung Utara',
                'trend' => 'stable',
                'last_updated' => date('Y-m-d H:i:s'),
                'case_types' => [
                    'Pencurian' => 38,
                    'Perampokan' => 20,
                    'Penipuan' => 17,
                    'Narkoba' => 8,
                    'Penganiayaan' => 12
                ]
            ]
        ];
        
        return $this->response->setJSON($summary);
    }
}