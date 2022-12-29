<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeguranModel extends Model
{
    use HasFactory;
    protected $table = 'teguran';
    protected $fillable = [
        'id_users',
        'kategori',
        'keterangan',
        'file_surat',
        'tanggal',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_users');
    }

    public function ket_kategori($id)
    {
        if($id == '1'){
            return '<span class="badge bg-danger text-dark"><i class="bi bi-exclamation-triangle me-1"></i>Pelanggaran</span>';
        }else{
            return '<span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i>Teguran</span>';
        }
    }
}
