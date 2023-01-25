<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\DepartemenModel;
use App\Models\LogSuratModel;
use App\Models\RapatModel;
use App\Models\SoalModel;
use App\Models\SuratModel;
use App\Models\TopikSeModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Rapat extends Controller
{

    public $button;

    public function __construct()
    {
        $this->button = new GetButton;
    }

    public function index(Request $request)
    {
        $title = 'Rapat';
        $data = RapatModel::order_by("tanggal", "DESC")->get();
        $button = $this->button;
        $cont = $this;
        return view('rapat.index', compact('data', 'title', 'button', 'cont'));
    }

    public function store(Request $request)
    {
        $title = 'Rapat';
        if ($request->isMethod('POST')) {
            $validatedData = $request->validate([
                'id_departemen' => 'required',
                'id_users' => 'required',
                'judul' => 'required',
                'kategori' => 'required',
                'tanggal' => 'required',
                'waktu_mulai' => 'required',
                'waktu_akhir' => 'required',
            ]);
            if ($validatedData) {
                // $uploadPath = public_path('upload/surat/');

                // if (!File::isDirectory($uploadPath)) {
                //     File::makeDirectory($uploadPath, 0755, true, true);
                // }
                // $file = $request->file('file_surat');
                // $extension = $file->getClientOriginalExtension();
                // $rename = date('YmdHis') . '.' . $extension;

                // if ($file->move($uploadPath, $rename)) {
                    // $tanggal_berakhir = date('Y-m-d', strtotime('+' . $request->reminder . ' month', strtotime($request->tanggal)));
                    $data = [
                        'id_departemen' => $request->id_departemen,
                        'id_users' => $request->id_users,
                        'judul' => $request->judul,
                        'kategori' => $request->kategori,
                        'tanggal' => $request->tanggal,
                        'waktu_mulai' => $request->waktu_mulai,
                        'waktu_akhir' => $request->waktu_akhir,
                        'created_by' => auth()->user()->username,
                        'updated_by' => auth()->user()->username,
                    ];
                    SuratModel::create($data);
                    return redirect($this->button->formEtc($title))->with('success', 'Input data berhasil');
                // }
            }
        } else {
            $button = $this->button;
            $user = UserModel::all();
            $departemen = DepartemenModel::all();
            return view('surat.add', compact('title', 'button', 'user', 'departemen'));
        }
    }

    public function update(Request $request)
    {
        if ($this->jenis == 'umum') {
            $title = 'Surat Edaran Umum';
        } else {
            $title = 'Surat Edaran Khusus';
        }
        $surat = SuratModel::findOrFail($request->id);
        $validatedData = $request->validate([
            'nomor_surat' => 'required',
            'id_topik' => 'required',
            'id_user' => 'required',
            'keterangan_topik' => 'required',
            'tanggal' => 'required',
            'status_se' => 'required',
            'ditujukan' => 'required',
            'reminder' => 'required',
        ]);

        if ($validatedData) {
            $tanggal_berakhir = date('Y-m-d', strtotime('+' . $request->reminder . ' month', strtotime($request->tanggal)));
            $surat->update([
                'nomor_surat' => $request->nomor_surat,
                'id_topik' => $request->id_topik,
                'id_user' => $request->id_user,
                'keterangan_topik' => $request->keterangan_topik,
                'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
                'status_se' => $request->status_se,
                'ditujukan' => $request->ditujukan,
                'reminder' => $request->reminder,
                'tanggal_berakhir' => $tanggal_berakhir,
                'status_terbit' => 0,
                'updated_by' => auth()->user()->email,
            ]);
            return redirect($this->button->formEtc($title).'/detail/'.$request->id)->with('success', 'Edit data berhasil');
        }
    }

    public function delete($id)
    {
        if ($this->jenis == 'umum') {
            $title = 'Surat Edaran Umum';
        } else {
            $title = 'Surat Edaran Khusus';
        }
        SuratModel::findOrFail($id)->delete();
        return redirect($this->button->formEtc($title))->with('success', 'Hapus data berhasil');
    }

    public function detail($id)
    {
        $data = SuratModel::find($id);
        $soal = SoalModel::where('id_surat', $id)->get();
        $topik = TopikSeModel::all();
        $user = UserModel::all();
        $departemen = DepartemenModel::all();
        $button = $this->button;
        if ($this->jenis == 'umum') {
            $title = 'Surat Edaran Umum';
        } else {
            $title = 'Surat Edaran Khusus';
        }
        $cont = $this;
        $baca = LogSuratModel::where(['id_surat' => $id, 'status' => 1])->get();
        $tuntas = LogSuratModel::where(['id_surat' => $id, 'status' => 2])->get();
        return view('surat.detail', compact('data', 'soal', 'topik', 'user', 'departemen', 'title', 'button', 'cont', 'baca', 'tuntas'));
    }

    public function ganti_surat(Request $request)
    {
        $uploadPath = public_path('upload/surat/');

        if (!File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true, true);
        }
        $file = $request->file('file_surat');
        $extension = $file->getClientOriginalExtension();
        $rename = date('YmdHis') . $extension;

        $surat = SuratModel::findOrFail($request->id);
        $surat->update([
            'file_surat' => $rename,
            'updated_by' => auth()->user()->email,
        ]);
        return redirect($this->button->formEtc('Pegawai') . '/info/' . $request->id)->with('success', 'Edit data berhasil');
    }

    public function getTarget($id_departemen)
    {
        if($id_departemen == 0){
            $user = UserModel::where('id_jabatan', 4)->count();
        }else{
            $user = UserModel::where(['id_jabatan' => 4, 'id_departemen' => $id_departemen])->count();
        }
        return $user;
    }

    public function getJmlStatus($id_surat)
    {
        $result['baca'] = LogSuratModel::where(['id_surat' => $id_surat, 'status' => 1])->count();
        $result['tuntas'] = LogSuratModel::where(['id_surat' => $id_surat, 'status' => 2])->count();
        return $result;
    }
}
