<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSoalModel extends Model
{
    use HasFactory;
    protected $table = 'jawaban_soal';
    protected $fillable = [
        'id_users',
        'id_soal',
        'jawaban',
        'is_benar',
        'created_by',
        'updated_by',
    ];
}
