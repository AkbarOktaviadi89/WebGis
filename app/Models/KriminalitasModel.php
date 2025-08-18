<?php
namespace App\Models;
use CodeIgniter\Model;

class KriminalitasModel extends Model
{
    protected $table = 'kriminalitas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'jenis_kejahatan', 'lokasi', 'latitude', 'longitude', 
        'tanggal_kejadian', 'keterangan'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}