<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasModel extends Model
{
    use HasFactory;
    protected $table = 'tugas';
    protected $fillable = [
        'id_users',
        'deskripsi',
        'tanggal',
        'lokasi',
        'catatan',
        'foto',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_users');
    }
}
