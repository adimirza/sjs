<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalModel extends Model
{
    use HasFactory;
    protected $table = 'soal';
    protected $fillable = [
        'id_surat',
        'pertanyaan',
        'pilihan',
        'kunci_jawaban',
        'created_by',
        'updated_by',
    ];

    public function surat()
    {
        return $this->belongsTo(SuratModel::class, 'id_surat');
    }

    public function pilihan_ganda($id)
    {
        $soal = SoalModel::find($id);
        $pilihan = json_decode($soal['pilihan'], true);
        return $pilihan;
    }
}
