<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSuratModel extends Model
{
    use HasFactory;
    protected $table = 'log_surat';
    protected $fillable = [
        'id_surat',
        'id_users',
        'status',
    ];

    public function surat()
    {
        return $this->belongsTo(SuratModel::class, 'id_surat');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_users');
    }

    public function ket_status($st)
    {
        switch ($st) {
            case 1:
                return "SE Dilihat.";
                break;
            case 2:
                return "SE Tuntas.";
                break;
            case 3:
                return "SE Belum Tuntas.";
                break;
            default:
                return "Belum Diketahui.";
        }
    }

    public function ket_member($st, $id_surat)
    {
        $surat = SuratModel::find($id_surat);
        $nilai = HistoryNilaiModel::where(['id_users' => auth()->user()->id, 'id_surat' => $id_surat])
                                    ->orderBy('created_at', 'DESC')->first();
        switch ($st) {
            case 1:
                return "Buka SE ".$surat->keterangan_topik.".";
                break;
            case 2:
                return "Mengerjakan Soal SE ".$surat->keterangan_topik.".";
                break;
            case 3:
                return "SE Tuntas.";
                break;
            default:
                return "Belum Diketahui.";
        }
    }
}
