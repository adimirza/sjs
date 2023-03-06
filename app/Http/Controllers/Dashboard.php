<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Lib\GetLibrary;
use App\Models\DepartemenModel;
use App\Models\HistoryNilaiModel;
use App\Models\JabatanModel;
use App\Models\RapatModel;
use App\Models\SuratModel;
use App\Models\TugasModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public $lib;
    public $button;

    public function __construct()
    {
        $this->lib = new GetLibrary;
        $this->button = new GetButton;
    }

    public function index(Request $request)
    {
        $data['title'] = 'Dashboard';
        $data['cont'] = $this;
        $data['bulan'] = date('m');
        $data['tahun'] = date('Y');
        if($request->all()){
            $data['bulan'] = $request->bulan;
            $data['tahun'] = $request->tahun;
        }
        $data['data_tugas'] = new TugasModel();
        $data['tgl'] = date('Y-m-d');
        if($request->tanggal){
            $data['tgl'] = date('Y-m-d', strtotime($request->tanggal));
        }
        if(auth()->user()->id_jabatan == '4'){
            $data['jml_paham_umum'] = HistoryNilaiModel::select("id_users")
                                ->join("surat", "history_nilai.id_surat", "=", "surat.id")
                                ->where(["nilai" => "nilai_max", 
                                         "id_users" => auth()->user()->id,
                                         "ditujukan" => 0])
                                ->distinct()->count();
            $data['jml_paham_divisi'] = HistoryNilaiModel::select("id_users")
                                ->join("surat", "history_nilai.id_surat", "=", "surat.id")
                                ->whereRaw("nilai = nilai_max AND ".
                                            "id_users = ".auth()->user()->id." AND ".
                                            "ditujukan = ".auth()->user()->id_departemen)
                                ->distinct()->count();
            $data['jml_umum'] = SuratModel::where("ditujukan", 0)->count();
            $data['jml_divisi'] = SuratModel::where("ditujukan", auth()->user()->id_departemen)->count();
            $data['tugas'] = TugasModel::selectRaw("DISTINCT(DATE_FORMAT(tanggal, '%Y-%m-%d')) as tanggal")
                                        ->whereRaw("MONTH(tanggal) = ".$data['bulan']." AND YEAR(tanggal) = ".$data['tahun']." AND id_users = ".auth()->user()->id)
                                        ->orderBy('tanggal')->get();
            $data['rapat'] = RapatModel::where(['tanggal' => $data['tgl'], 'id_departemen' => auth()->user()->id_departemen])
                                        ->orderBy('waktu_mulai')->get();
            return view('dashboard.index_member', $data);
        }elseif(auth()->user()->jabatan->id_role == '5'){
            $data['jml_umum'] = SuratModel::whereRaw("ditujukan = 0 AND YEAR(tanggal) = ".$data['tahun'].
                                                    " AND MONTH(tanggal) = ".$data['bulan'])->count();
            $data['jml_khusus'] = SuratModel::whereRaw("ditujukan = ".auth()->user()->id_departemen.
                                                        " AND YEAR(tanggal) = ".$data['tahun'].
                                                        " AND MONTH(tanggal) = ".$data['bulan'])->count();
            $data['jml_staff'] = UserModel::where(["id_jabatan" => 4, 
                                                   "id_departemen" => auth()->user()->id_departemen])->count();
            $data['jml_paham'] = HistoryNilaiModel::select("id_users")
                                                    ->join("users", "history_nilai.id_users", "=", "users.id")
                                                    ->whereRaw("nilai = nilai_max AND id_departemen = ".
                                                        auth()->user()->id_departemen)
                                                    ->distinct()->count();
            $data['departemen'] = DepartemenModel::all();
            $data['tugas'] = TugasModel::selectRaw("DISTINCT(DATE_FORMAT(tanggal, '%Y-%m-%d')) as tanggal")
                                        ->join("users", "tugas.id_users", "=", "users.id")
                                        ->whereRaw("MONTH(tanggal) = ".$data['bulan']." AND YEAR(tanggal) = ".
                                        $data['tahun']." AND id_departemen = ".auth()->user()->id_departemen)
                                        ->orderBy('tanggal')->get();
            $data['rapat'] = RapatModel::where('tanggal', $data['tgl'])->orderBy('waktu_mulai')->get();
            return view('dashboard.index', $data);
        }else{
            $data['jml_umum'] = SuratModel::whereRaw("ditujukan = 0 AND YEAR(tanggal) = ".$data['tahun'].
                                            " AND MONTH(tanggal) = ".$data['bulan'])->count();
            $data['jml_khusus'] = SuratModel::whereRaw("ditujukan != 0 AND YEAR(tanggal) = ".$data['tahun'].
                                            " AND MONTH(tanggal) = ".$data['bulan'])->count();
            $data['jml_staff'] = UserModel::where("id_jabatan", 4)->count();
            $data['jml_paham'] = HistoryNilaiModel::select("id_users")->whereRaw("nilai = nilai_max")->distinct()->count();
            $data['departemen'] = DepartemenModel::all();
            $data['tugas'] = TugasModel::selectRaw("DISTINCT(DATE_FORMAT(tanggal, '%Y-%m-%d')) as tanggal")
                                        ->whereRaw("MONTH(tanggal) = ".$data['bulan'].
                                                   " AND YEAR(tanggal) = ".$data['tahun'])
                                        ->orderBy('tanggal')->get();
            $data['rapat'] = RapatModel::where('tanggal', $data['tgl'])->orderBy('waktu_mulai')->get();
            return view('dashboard.index', $data);
        }
    }

    public function getKunjungan($tgl){
        $tgl = date('Y-m-d', strtotime($tgl));
        $data = TugasModel::whereRaw("DATE(tanggal) = '$tgl'")->get();
        return $data;
    }

    public function getJmlDepartemen($id_departemen){
        $data = UserModel::where("id_departemen", $id_departemen)->count();
        return $data;
    }
}
