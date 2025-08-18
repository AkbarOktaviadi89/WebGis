<?php
namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $this->data['page_title'] = 'Dashboard - WebGIS Kriminalitas';
        $this->data['breadcrumb'] = 'Dashboard';
        
        // Data statistik untuk dashboard sesuai dengan informasi Kabupaten Bandung
        $this->data['stats'] = [
            'total_incidents' => 1247,      // Total laporan yang diterima
            'monthly_incidents' => 87,       // Insiden bulan ini (bisa digunakan untuk statistik tambahan)
            'high_risk_areas' => 12,         // Area berisiko tinggi (bisa digunakan untuk statistik tambahan)
            'resolved_cases' => 1098         // Jumlah kasus yang ditangani/selesai
        ];
        
        // Data tambahan untuk sistem informasi
        $this->data['system_info'] = [
            'total_districts' => 31,         // Jumlah kecamatan di Kabupaten Bandung
            'total_police_stations' => 18,   // Jumlah Polsek di Kabupaten Bandung
            'last_update' => date('Y-m-d H:i:s'),
            'coverage_area' => 'Kabupaten Bandung'
        ];
        
        // Data berita highlight (bisa diambil dari database)
        $this->data['news_highlights'] = [
            [
                'title' => 'Operasi Keamanan Terpadu',
                'content' => 'Polres Bandung melakukan operasi keamanan terpadu di wilayah rawan kriminalitas.',
                'date' => '2 hari yang lalu',
                'type' => 'operation',
                'icon' => 'fas fa-bullhorn'
            ],
            [
                'title' => 'Penurunan Tingkat Kriminalitas',
                'content' => 'Tingkat kriminalitas di Kabupaten Bandung mengalami penurunan 15% dibanding bulan lalu.',
                'date' => '5 hari yang lalu',
                'type' => 'statistics',
                'icon' => 'fas fa-chart-line'
            ],
            [
                'title' => 'Kebijakan Pengawasan Digital',
                'content' => 'Penerapan sistem pengawasan digital untuk meningkatkan keamanan wilayah.',
                'date' => '1 minggu yang lalu',
                'type' => 'policy',
                'icon' => 'fas fa-balance-scale'
            ]
        ];
        
        return view('dashboard/index', $this->data);
    }
    
    /**
     * Method untuk mengambil data statistik real-time (AJAX)
     */
    public function getStats()
    {
        // Simulasi pengambilan data real-time dari database
        $stats = [
            'total_incidents' => rand(1200, 1300),
            'monthly_incidents' => rand(80, 100),
            'resolved_cases' => rand(1000, 1150),
            'districts' => 31,
            'police_stations' => 18
        ];
        
        return $this->response->setJSON($stats);
    }
    
    /**
     * Method untuk mengambil data berita terbaru (AJAX)
     */
    public function getLatestNews()
    {
        // Simulasi pengambilan berita terbaru dari database
        $news = [
            [
                'title' => 'Update Operasi Keamanan',
                'content' => 'Hasil operasi keamanan menunjukkan penurunan signifikan kejahatan jalanan.',
                'date' => date('Y-m-d H:i:s'),
                'category' => 'security'
            ]
            // ... data berita lainnya
        ];
        
        return $this->response->setJSON($news);
    }
}