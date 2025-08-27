<?php
namespace App\Models;
use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'judul', 'konten', 'kategori', 'gambar', 'tanggal_publikasi',
        'penulis', 'status', 'is_highlight', 'views'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'judul' => 'required|max_length[200]',
        'konten' => 'required',
        'status' => 'in_list[draft,published,archived]'
    ];

    public function getPublishedNews($limit = null)
    {
        $builder = $this->where('status', 'published')
                       ->orderBy('tanggal_publikasi', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    public function getHighlightNews($limit = 3)
    {
        return $this->where('status', 'published')
                   ->where('is_highlight', 1)
                   ->orderBy('tanggal_publikasi', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }
}