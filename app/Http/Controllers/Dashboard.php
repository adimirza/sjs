<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Lib\GetLibrary;
use App\Models\DepartemenModel;
use App\Models\HistoryNilaiModel;
use App\Models\JabatanModel;
use App\Models\SuratModel;
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
            return view('dashboard.index_member', $data);
        }else{
            $data['bulan'] = date('m');
            $data['tahun'] = date('Y');
            if($request->all()){
                $data['bulan'] = $request->bulan;
                $data['tahun'] = $request->tahun;
            }
            $data['jml_umum'] = SuratModel::whereRaw("ditujukan = 0 AND YEAR(tanggal) = ".$data['tahun']." AND MONTH(tanggal) = ".$data['bulan'])->count();
            $data['jml_khusus'] = SuratModel::whereRaw("ditujukan != 0 AND YEAR(tanggal) = ".$data['tahun']." AND MONTH(tanggal) = ".$data['bulan'])->count();
            $data['jml_staff'] = UserModel::where("id_jabatan", 4)->count();
            $data['jml_paham'] = HistoryNilaiModel::select("id_users")->whereRaw("nilai = nilai_max")->distinct()->count();
            $data['departemen'] = DepartemenModel::all();
            return view('dashboard.index', $data);
        }
    }

    public function getJmlDepartemen($id_departemen){
        $data = UserModel::where("id_departemen", $id_departemen)->count();
        return $data;
    }
}
