<?php

namespace App\Lib;

use App\Models\LogRapatModel;
use App\Models\LogSuratModel;
use App\Models\RapatModel;
use App\Models\SuratModel;

class GetLibrary
{
  public $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 
                  'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
  public $hari = ['Sun' => 'Minggu', 'Mon' => 'Senin', 'Tue' => 'Selasa', 'Wed' => 'Rabu', 
                  'Thu' => 'Kamis', 'Fri' => 'Jumat', 'Sat' => 'Sabtu'];
  public $stLogSurat = ['Belum Dibaca', 'Sudah Dibaca', 'Tuntas', 'Belum Tuntas'];

  public function forTanggal($tgl){
    $hr = date('d', strtotime($tgl));
    $bln = intval(date('m', strtotime($tgl)));
    $thn = date('Y', strtotime($tgl));

    return $hr.' '.$this->bulan[$bln].' '.$thn;
  }
  
  public function getNotifSurat(){
    $id_departemen = auth()->user()->id_departemen;
    $id_user = auth()->user()->id;
    $result['blmDibaca'] = 0;
    $result['blmTuntas'] = 0;
    $surat = SuratModel::whereRaw("ditujukan = $id_departemen OR ditujukan = 0")->get();
    foreach($surat as $srt){
      $log = LogSuratModel::where(["id_users" => $id_user, "id_surat" => $srt['id']])->first();
      if(!$log){
        $result['blmDibaca']++;
      }elseif($log['status'] == 3){
        $result['blmTuntas']++;
      }
    }
    return $result;
  }

  public function getNotifRapat(){
    $id_departemen = auth()->user()->id_departemen;
    $id_user = auth()->user()->id;
    $result['blmKonfirmasi'] = 0;
    $rapat = RapatModel::whereRaw("id_departemen = $id_departemen OR id_departemen = 0")->get();
    foreach($rapat as $rpt){
      $log = LogRapatModel::where(["id_users" => $id_user, "id_rapat" => $rpt['id']])->first();
      if(!$log){
        $result['blmKonfirmasi']++;
      }
    }
    return $result;
  }

  public function getKonfirmasiRapat($id_rapat)
  {
    $id_user = auth()->user()->id;
    $result = LogRapatModel::where(['id_users' => $id_user, 'id_rapat' => $id_rapat])->first();
    return $result;
  }
}
