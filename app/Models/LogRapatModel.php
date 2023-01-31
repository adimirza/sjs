<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogRapatModel extends Model
{
    use HasFactory;
    protected $table = 'log_rapat';
    protected $fillable = [
        'id_rapat',
        'id_users',
        'konfirmasi',
        'keterangan',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_users');
    }

    public function rapat()
    {
        return $this->belongsTo(RapatModel::class, 'id_rapat');
    }
}
