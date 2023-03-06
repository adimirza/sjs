<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\DepartemenModel;
use App\Models\TugasModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class Tugas extends Controller
{

    public $button;

    public function __construct()
    {
        $this->button = new GetButton;
    }

    public function index(Request $request)
    {
        $title = 'Kunjungan';
        $id_departemen = '';
        $id_pegawai = '';
        $tgl_awal = '';
        $tgl_akhir = '';
        if(auth()->user()->jabatan->role->nama == 'Member'){
            $id_users = auth()->user()->id;
            $data = TugasModel::where("id_users", $id_users)
                                ->orderBy("tanggal", "DESC")->get();
        }else{
            if($request->all()){
                $id_departemen = $request->id_departemen;
                $id_pegawai = $request->id_pegawai;
                $tgl_awal = date('Y-m-d', strtotime($request->tgl_awal));
                $tgl_akhir = date('Y-m-d', strtotime($request->tgl_akhir));
                $data = TugasModel::whereRaw("id_users = $id_pegawai AND DATE_FORMAT(tanggal, '%Y-%m-%d') BETWEEN '$tgl_awal' AND '$tgl_akhir'")->orderBy("tanggal", "DESC")->get();
            }else{
                $data = TugasModel::orderBy("tanggal", "DESC")->get();
            }
        }
        $button = $this->button;
        $cont = $this;
        
        $departemen = DepartemenModel::all();
        return view('tugas.index', compact('data', 'title', 'button', 'cont', 'departemen', 
                                            'id_departemen', 'id_pegawai', 'tgl_awal', 'tgl_akhir'));
    }

    public function store(Request $request)
    {
        $title = 'Kunjungan';
        if ($request->isMethod('POST')) {
            $validatedData = $request->validate([
                'id_users' => 'required',
                'nama_customer' => 'required',
                'deskripsi' => 'required',
                'tanggal' => 'required',
                'lokasi' => 'required',
                'status' => 'required',
            ]);
            if ($validatedData) {
                $data = [
                    'id_users' => $request->id_users,
                    'nama_customer' => $request->nama_customer,
                    'deskripsi' => $request->deskripsi,
                    'tanggal' => $request->tanggal,
                    'lokasi' => $request->lokasi,
                    'status' => $request->status,
                    'created_by' => auth()->user()->username,
                    'updated_by' => auth()->user()->username,
                ];
                TugasModel::create($data);
                return redirect($this->button->formEtc($title))->with('success', 'Input data berhasil');
            }
        } else {
            $button = $this->button;
            // $user = UserModel::all();
            $departemen = DepartemenModel::all();
            return view('tugas.add', compact('title', 'button', 'departemen'));
        }
    }

    public function update(Request $request)
    {
        $title = 'Kunjungan';
        $rapat = TugasModel::findOrFail($request->id);
        $validatedData = $request->validate([
            'id_users' => 'required',
            'nama_customer' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'lokasi' => 'required',
            'status' => 'required',
        ]);

        if ($validatedData) {
            $rapat->update([
                'id_users' => $request->id_users,
                'nama_customer' => $request->nama_customer,
                'deskripsi' => $request->deskripsi,
                'tanggal' => $request->tanggal,
                'lokasi' => $request->lokasi,
                'status' => $request->status,
                'updated_by' => auth()->user()->username,
            ]);
            return redirect($this->button->formEtc($title) . '/detail/' . $request->id)->with('success', 'Edit data berhasil');
        }
    }

    public function delete($id)
    {
        $title = 'Kunjungan';
        TugasModel::findOrFail($id)->delete();
        return redirect($this->button->formEtc($title))->with('success', 'Hapus data berhasil');
    }

    public function detail($id)
    {
        $data = TugasModel::find($id);
        $user = UserModel::all();
        $departemen = DepartemenModel::all();
        $button = $this->button;
        $title = 'Kunjungan';
        $cont = $this;
        return view('tugas.detail', compact('data', 'user', 'departemen', 'title', 'button', 'cont'));
    }

    public function update_foto(Request $request)
    {
        $image = $request->file('foto');
        $imagename = $request->id . time() . '.' . $image->extension();
        $destinationPath = public_path('upload/image/tugas');
        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true, true);
        }
        $img = Image::make($image->path());
        $img->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imagename);

        $tugas = TugasModel::findOrFail($request->id);
        $tugas->update([
            'foto' => $imagename,
            'updated_by' => auth()->user()->username,
        ]);
        return redirect($this->button->formEtc('Kunjungan') . '/detail/' . $request->id)->with('success', 'Edit foto berhasil');
    }

    public function update_catatan(Request $request)
    {
        $tugas = TugasModel::findOrFail($request->id);
        $tugas->update([
            'catatan' => $request->catatan,
            'updated_by' => auth()->user()->email,
        ]);
        return redirect($this->button->formEtc('Kunjungan') . '/detail/' . $request->id)->with('success', 'Edit catatan berhasil');
    }

    public function getdata(Request $request)
    {
        $user = UserModel::where('id_departemen', $request->id)->get();
        return json_encode($user);
    }
}
