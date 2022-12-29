<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryNilaiModel extends Model
{
    use HasFactory;
    protected $table = 'history_nilai';
    protected $fillable = [
        'id_users',
        'id_surat',
        'nilai',
        'nilai_max',
        'created_by',
        'updated_by',
    ];

    public function surat()
    {
        return $this->belongsTo(SuratModel::class, 'id_surat');
    }

    public function users()
    {
        return $this->belongsTo(UserModel::class, 'id_users');
    }
}
