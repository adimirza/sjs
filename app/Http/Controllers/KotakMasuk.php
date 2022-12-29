<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Lib\GetLibrary;
use App\Models\HistoryNilaiModel;
use App\Models\JawabanSoalModel;
use App\Models\LogSuratModel;
use App\Models\SoalModel;
use App\Models\SuratModel;
use Illuminate\Http\Request;

class KotakMasuk extends Controller
{

    public $button;
    public $jenis;
    public $lib;

    public function __construct()
    {
        $this->button = new GetButton;
        $this->lib = new GetLibrary;
        $this->jenis = request()->segment(2);
    }

    public function index(Request $request)
    {
        $title = 'Kotak Masuk';
        $bulan = 0;
        $tahun = 0;
        if (!$request->all()) {
            $surat = new SuratModel();
            $data = $surat->kotak_masuk()->get();
        } else {
            $bulan = $request->bulan;
            $tahun = $request->tahun;
            $data = SuratModel::whereRaw("ditujukan = 0 OR ditujukan = " . auth()->user()->id_departemen . " AND MONTH(tanggal) = $bulan AND YEAR(tanggal) = $tahun")->get();
        }
        $button = $this->button;
        $lib = $this->lib;
        return view('kotak_masuk.index', compact('data', 'title', 'button', 'lib', 'bulan', 'tahun'));
    }

    public function getJawaban($id_soal)
    {
        $result = [
            'jawaban' => '',
            'is_benar' => 0 
        ];
        $jawaban = JawabanSoalModel::where(['id_users' => auth()->user()->id, 'id_soal' => $id_soal])->first();
        if($jawaban){
            $result = [
                'jawaban' => $jawaban->jawaban,
                'is_benar' => $jawaban->is_benar 
            ];
        }
        return $result;
    }

    public function jawab_soal(Request $request)
    {
        $jml = $request->jumlah;
        $benar = 0;
        $jml_benar = 0;
        for ($i = 1; $i <= $jml; $i++) {
            $soal = SoalModel::find($request->id_soal[$i]);
            $jawaban = JawabanSoalModel::where(['id_users' => auth()->user()->id, 'id_soal' => $soal['id']])->first();
            if ($soal['kunci_jawaban'] == $request->jawaban[$i]) {
                $benar = 1;
                $jml_benar = $jml_benar + 1;
            }
            $data = [
                'id_users' => auth()->user()->id,
                'id_soal' => $request->id_soal[$i],
                'jawaban' => $request->jawaban[$i],
                'is_benar' => $benar,
                'created_by' => auth()->user()->username,
                'updated_by' => auth()->user()->username,
            ];
            if(!$jawaban){
                JawabanSoalModel::create($data);
            }else{
                $jawaban->update($data);
            }
            $benar = 0;
        }
        $dt_history = [
            'id_users' => auth()->user()->id,
            'id_surat' => $soal['id_surat'],
            'nilai' => $jml_benar,
            'nilai_max' => $jml,
            'created_by' => auth()->user()->username,
            'updated_by' => auth()->user()->username,
        ];
        HistoryNilaiModel::create($dt_history);
        $persen = ($jml_benar/$jml) * 100;
        $status = 3;
        if($persen >= 80){
            $status = 2;
        }
        $cek = LogSuratModel::where(['id_surat' => $soal['id_surat'], 'id_users' => auth()->user()->id, 'status' => '2'])->first();
        if (!$cek) {
            LogSuratModel::create([
                'id_users' => auth()->user()->id,
                'id_surat' => $soal['id_surat'],
                'status' => $status
            ]);
        }
        return redirect($this->button->formEtc('Kotak Masuk') . '/detail/'.$soal['id_surat'])->with('success', 'Input data berhasil');
    }

    public function detail($id)
    {
        $cek = LogSuratModel::where(['id_surat' => $id, 'id_users' => auth()->user()->id, 'status' => '1'])->first();
        if (!$cek) {
            LogSuratModel::create([
                'id_users' => auth()->user()->id,
                'id_surat' => $id,
                'status' => '1'
            ]);
        }
        $nilai = HistoryNilaiModel::where(['id_users' => auth()->user()->id, 'id_surat' => $id])->first();
        $data = SuratModel::find($id);
        $soal = SoalModel::where('id_surat', $id)->get();
        $button = $this->button;
        $cont = $this;
        $title = 'Kotak Masuk';
        return view('kotak_masuk.detail', compact('data', 'soal', 'title', 'nilai', 'button', 'cont'));
    }
}
