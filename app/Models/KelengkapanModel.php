<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelengkapanModel extends Model
{
    use HasFactory;
    protected $table = 'kelengkapan';
    protected $fillable = [
        'id_users',
        'id_atribut',
        'check_admin',
        'check_user',
        'keterangan',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_users');
    }

    public function atribut()
    {
        return $this->belongsTo(AtributModel::class, 'id_atribut');
    }
}
