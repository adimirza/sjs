<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilWebModel extends Model
{
    use HasFactory;
    protected $table = 'bs_profil_web';
    protected $fillable = [
        'id',
        'nama',
        'deskripsi',
        'logo',
        'versi',
        'created_by',
        'updated_by',
    ];
}
