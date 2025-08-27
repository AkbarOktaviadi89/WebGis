<?php
namespace App\Models;
use CodeIgniter\Model;

class WilayahModel extends Model
{
    protected $table = 'wilayah';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_wilayah', 'kode_wilayah', 'jenis_wilayah', 'parent_id',
        'latitude', 'longitude', 'luas_wilayah', 'jumlah_penduduk',
        'kepadatan_penduduk', 'keterangan', 'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'nama_wilayah' => 'required|max_length[100]',
        'kode_wilayah' => 'required|max_length[20]|is_unique[wilayah.kode_wilayah,id,{id}]',
        'jenis_wilayah' => 'in_list[kecamatan,kelurahan,rw,rt]'
    ];

    // Get all active regions
    public function getActiveRegions($type = null)
    {
        $builder = $this->where('is_active', 1);
        
        if ($type) {
            $builder->where('jenis_wilayah', $type);
        }
        
        return $builder->orderBy('nama_wilayah')->findAll();
    }

    // Get regions with crime statistics
    public function getRegionsWithCrimeStats()
    {
        return $this->db->query("
            SELECT w.*, 
                   COALESCE(crime_stats.total_crimes, 0) as total_crimes,
                   COALESCE(crime_stats.high_risk_crimes, 0) as high_risk_crimes
            FROM wilayah w
            LEFT JOIN (
                SELECT lokasi,
                       COUNT(*) as total_crimes,
                       SUM(CASE WHEN tingkat_bahaya = 'tinggi' THEN 1 ELSE 0 END) as high_risk_crimes
                FROM kriminalitas 
                GROUP BY lokasi
            ) crime_stats ON w.nama_wilayah = crime_stats.lokasi
            WHERE w.is_active = 1
            ORDER BY crime_stats.total_crimes DESC
        ")->getResultArray();
    }
}