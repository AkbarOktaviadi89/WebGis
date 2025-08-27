<?php
namespace App\Models;
use CodeIgniter\Model;

class InstansiModel extends Model
{
    protected $table = 'instansi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_instansi', 'jenis_instansi', 'alamat', 'latitude', 'longitude',
        'wilayah_id', 'telepon', 'email', 'kepala_instansi', 'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'nama_instansi' => 'required|max_length[100]',
        'jenis_instansi' => 'in_list[polsek,polres,polda,tni,satpol_pp]',
        'email' => 'valid_email'
    ];

    public function getInstansiWithWilayah()
    {
        return $this->builder()
                   ->select('instansi.*, wilayah.nama_wilayah')
                   ->join('wilayah', 'wilayah.id = instansi.wilayah_id', 'left')
                   ->where('instansi.is_active', 1)
                   ->orderBy('instansi.nama_instansi')
                   ->get()->getResultArray();
    }
}