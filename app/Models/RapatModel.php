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

    public function status($id)
    {
        $rapat = RapatModel::find($id);
        $result = [
            'id' => 0,
            'keterangan' => 'Akan Datang',
            'class' => 'primary'
        ];
        $now = date('Y-m-d H:i');
        if($rapat){
            $tgl_mulai = date('Y-m-d H:i', strtotime($rapat->tanggal.' '.$rapat->waktu_mulai));
            $tgl_akhir = date('Y-m-d H:i', strtotime($rapat->tanggal.' '.$rapat->waktu_akhir));
            if(($tgl_mulai <= $now) AND ($tgl_akhir > $now)){
                $result = [
                    'id' => 1,
                    'keterangan' => 'Sedang Berlangsung',
                    'class' => 'warning'
                ];
            }elseif($tgl_akhir <= $now){
                $result = [
                    'id' => 2,
                    'keterangan' => 'Telah Berakhir',
                    'class' => 'success'
                ];
            }
        }
        return $result;
    }
}
