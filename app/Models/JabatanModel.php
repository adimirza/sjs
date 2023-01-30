<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanModel extends Model
{
    use HasFactory;
    protected $table = 'jabatan';
    protected $fillable = [
        'nama',
        'id_role',
        'created_by',
        'updated_by',
    ];

    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'id_role');
    }
}
