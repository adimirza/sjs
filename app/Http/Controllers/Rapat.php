<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Lib\GetLibrary;
use App\Models\DepartemenModel;
use App\Models\LogRapatModel;
use App\Models\RapatModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class Rapat extends Controller
{

    public $button;
    public $lib;

    public function __construct()
    {
        $this->button = new GetButton;
        $this->lib = new GetLibrary;
    }

    public function index(Request $request)
    {
        $title = 'Rapat';
        if(auth()->user()->jabatan->role->nama == 'Member'){
            $id_departemen = auth()->user()->id_departemen;
            $data = RapatModel::whereRaw("id_departemen = $id_departemen OR id_departemen = 0")
                                ->orderBy("tanggal", "DESC")->get();
        }else{
            $data = RapatModel::orderBy("tanggal", "DESC")->get();
        }
        
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
                $data = [
                    'id_departemen' => $request->id_departemen,
                    'id_users' => $request->id_users,
                    'judul' => $request->judul,
                    'kategori' => $request->kategori,
                    'tanggal' => $request->tanggal,
                    'waktu_mulai' => $request->waktu_mulai,
                    'waktu_akhir' => $request->waktu_akhir,
                    'link' => $request->link,
                    'created_by' => auth()->user()->username,
                    'updated_by' => auth()->user()->username,
                ];
                RapatModel::create($data);
                return redirect($this->button->formEtc($title))->with('success', 'Input data berhasil');
            }
        } else {
            $button = $this->button;
            $user = UserModel::all();
            $departemen = DepartemenModel::all();
            return view('rapat.add', compact('title', 'button', 'user', 'departemen'));
        }
    }

    public function update(Request $request)
    {
        $title = 'Rapat';
        $rapat = RapatModel::findOrFail($request->id);
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
            $rapat->update([
                'id_departemen' => $request->id_departemen,
                'id_users' => $request->id_users,
                'judul' => $request->judul,
                'kategori' => $request->kategori,
                'tanggal' => $request->tanggal,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_akhir' => $request->waktu_akhir,
                'link' => $request->link,
                'updated_by' => auth()->user()->username,
            ]);
            return redirect($this->button->formEtc($title) . '/detail/' . $request->id)->with('success', 'Edit data berhasil');
        }
    }

    public function delete($id)
    {
        $title = 'Rapat';
        RapatModel::findOrFail($id)->delete();
        return redirect($this->button->formEtc($title))->with('success', 'Hapus data berhasil');
    }

    public function detail($id)
    {
        $data = RapatModel::find($id);
        $user = UserModel::all();
        $departemen = DepartemenModel::all();
        $log_rapat = LogRapatModel::where('id_rapat', $id)->get();
        $button = $this->button;
        $title = 'Rapat';
        $cont = $this;
        return view('rapat.detail', compact('data', 'user', 'departemen', 'log_rapat', 'title', 'button', 'cont'));
    }

    public function update_foto(Request $request)
    {
        $image = $request->file('foto');
        $imagename = $request->id . time() . '.' . $image->extension();
        $destinationPath = public_path('upload/image/rapat');
        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true, true);
        }
        $img = Image::make($image->path());
        $img->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imagename);

        $rapat = RapatModel::findOrFail($request->id);
        $rapat->update([
            'foto' => $imagename,
            'updated_by' => auth()->user()->username,
        ]);
        return redirect($this->button->formEtc('Rapat') . '/detail/' . $request->id)->with('success', 'Edit foto berhasil');
    }

    public function update_catatan(Request $request)
    {
        $rapat = RapatModel::findOrFail($request->id);
        $rapat->update([
            'catatan' => $request->catatan,
            'updated_by' => auth()->user()->username,
        ]);
        return redirect($this->button->formEtc('Rapat') . '/detail/' . $request->id)->with('success', 'Edit catatan berhasil');
    }

    public function konfirmasi(Request $request)
    {
        $data = [
            'konfirmasi' => $request->konfirmasi,
            'keterangan' => $request->keterangan,
            'updated_by' => auth()->user()->username,
        ];
        if($request->st == 'input'){
            $data['id_users'] = auth()->user()->id;
            $data['id_rapat'] = $request->id;
            $data['created_by'] = auth()->user()->username;
            LogRapatModel::create($data);
        }else{
            LogRapatModel::findOrFail($request->id)->update($data);
        }
        return redirect($this->button->formEtc('Rapat'));
    }
}
