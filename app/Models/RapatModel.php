<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RapatModel extends Model
{
    use HasFactory;
    protected $table = 'rapat';
    protected $fillable = [
        'id_departemen',
        'id_users',
        'judul',
        'kategori',
        'tanggal',
        'waktu_mulai',
        'waktu_akhir',
        'link',
        'catatan',
        'foto',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_users');
    }

    public function departemen()
    {
        return $this->belongsTo(DepartemenModel::class, 'id_departemen');
    }
}
