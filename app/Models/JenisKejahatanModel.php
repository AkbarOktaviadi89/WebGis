<?php
namespace App\Models;
use CodeIgniter\Model;

class JenisKejahatanModel extends Model
{
    protected $table = 'jenis_kejahatan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_jenis', 'kode_jenis', 'kategori', 'deskripsi',
        'tingkat_bahaya_default', 'warna_marker', 'icon_class', 'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'nama_jenis' => 'required|max_length[100]|is_unique[jenis_kejahatan.nama_jenis,id,{id}]',
        'kode_jenis' => 'required|max_length[20]|is_unique[jenis_kejahatan.kode_jenis,id,{id}]',
        'tingkat_bahaya_default' => 'in_list[rendah,sedang,tinggi]',
        'warna_marker' => 'regex_match[/^#[0-9A-Fa-f]{6}$/]'
    ];

    public function getActiveCrimeTypes()
    {
        return $this->where('is_active', 1)
                   ->orderBy('nama_jenis')
                   ->findAll();
    }

    public function getCrimeTypeWithStats()
    {
        return $this->db->query("
            SELECT jk.*, 
                   COALESCE(crime_count.total, 0) as total_cases,
                   COALESCE(crime_count.this_month, 0) as this_month_cases
            FROM jenis_kejahatan jk
            LEFT JOIN (
                SELECT jenis_kejahatan,
                       COUNT(*) as total,
                       SUM(CASE WHEN MONTH(tanggal_kejadian) = MONTH(NOW()) 
                                AND YEAR(tanggal_kejadian) = YEAR(NOW()) 
                           THEN 1 ELSE 0 END) as this_month
                FROM kriminalitas 
                GROUP BY jenis_kejahatan
            ) crime_count ON jk.nama_jenis = crime_count.jenis_kejahatan
            WHERE jk.is_active = 1
            ORDER BY crime_count.total DESC
        ")->getResultArray();
    }
}