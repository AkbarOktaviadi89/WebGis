<?php
namespace App\Models;
use CodeIgniter\Model;

class KriminalitasModel extends Model
{
    protected $table = 'kriminalitas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'jenis_kejahatan', 'lokasi', 'alamat_detail', 'latitude', 'longitude', 
        'tanggal_kejadian', 'waktu_kejadian', 'keterangan', 'tingkat_bahaya', 
        'status', 'jumlah_korban', 'kerugian_estimasi', 'pelapor', 'nomor_laporan'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'jenis_kejahatan' => 'required|max_length[100]',
        'lokasi' => 'required|max_length[200]',
        'tanggal_kejadian' => 'required|valid_date',
        'tingkat_bahaya' => 'in_list[rendah,sedang,tinggi]',
        'status' => 'in_list[dilaporkan,proses,selesai]'
    ];

    // Get statistics by date range
    public function getStatisticsByDate($startDate = null, $endDate = null)
    {
        $builder = $this->builder();
        
        if ($startDate) {
            $builder->where('tanggal_kejadian >=', $startDate);
        }
        if ($endDate) {
            $builder->where('tanggal_kejadian <=', $endDate);
        }
        
        return $builder->select('jenis_kejahatan, COUNT(*) as total')
                      ->groupBy('jenis_kejahatan')
                      ->orderBy('total', 'DESC')
                      ->get()->getResultArray();
    }

    // Get statistics by location
    public function getStatisticsByLocation()
    {
        return $this->builder()
                   ->select('lokasi, COUNT(*) as total, tingkat_bahaya')
                   ->groupBy(['lokasi', 'tingkat_bahaya'])
                   ->orderBy('total', 'DESC')
                   ->get()->getResultArray();
    }

    // Get monthly trend
    public function getMonthlyTrend($year = null)
    {
        if (!$year) $year = date('Y');
        
        return $this->builder()
                   ->select("MONTH(tanggal_kejadian) as bulan, COUNT(*) as total")
                   ->where('YEAR(tanggal_kejadian)', $year)
                   ->groupBy('MONTH(tanggal_kejadian)')
                   ->orderBy('bulan')
                   ->get()->getResultArray();
    }

    // Get crime data for map with coordinates
    public function getMapData($filters = [])
    {
        $builder = $this->builder()
                       ->select('id, jenis_kejahatan, lokasi, latitude, longitude, tingkat_bahaya, status, tanggal_kejadian, keterangan')
                       ->where('latitude IS NOT NULL')
                       ->where('longitude IS NOT NULL');

        if (isset($filters['jenis_kejahatan']) && !empty($filters['jenis_kejahatan'])) {
            $builder->where('jenis_kejahatan', $filters['jenis_kejahatan']);
        }
        
        if (isset($filters['lokasi']) && !empty($filters['lokasi'])) {
            $builder->like('lokasi', $filters['lokasi']);
        }
        
        if (isset($filters['tingkat_bahaya']) && !empty($filters['tingkat_bahaya'])) {
            $builder->where('tingkat_bahaya', $filters['tingkat_bahaya']);
        }

        return $builder->get()->getResultArray();
    }

    // Get summary statistics
    public function getSummaryStats()
    {
        $total = $this->countAll();
        $thisMonth = $this->where('MONTH(tanggal_kejadian)', date('n'))
                         ->where('YEAR(tanggal_kejadian)', date('Y'))
                         ->countAllResults();
        
        $resolved = $this->where('status', 'selesai')->countAllResults();
        
        $highestArea = $this->builder()
                           ->select('lokasi, COUNT(*) as total')
                           ->groupBy('lokasi')
                           ->orderBy('total', 'DESC')
                           ->limit(1)
                           ->get()->getRowArray();

        return [
            'total_cases' => $total,
            'monthly_cases' => $thisMonth,
            'resolved_cases' => $resolved,
            'highest_area' => $highestArea['lokasi'] ?? 'Tidak ada data',
            'case_types' => $this->getStatisticsByDate()
        ];
    }
}
