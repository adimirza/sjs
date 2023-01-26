<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\TugasModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Tugas extends Controller
{

    public $button;

    public function __construct()
    {
        $this->button = new GetButton;
    }

    public function index(Request $request)
    {
        $title = 'Tugas';
        $data = TugasModel::orderBy("tanggal", "DESC")->get();
        $button = $this->button;
        $cont = $this;
        return view('rapat.index', compact('data', 'title', 'button', 'cont'));
    }

    public function store(Request $request)
    {
        $title = 'Tugas';
        if ($request->isMethod('POST')) {
            $validatedData = $request->validate([
                'id_users' => 'required',
                'deskripsi' => 'required',
                'tanggal' => 'required',
                'lokasi' => 'required',
            ]);
            if ($validatedData) {
                $data = [
                    'id_users' => $request->id_users,
                    'deskripsi' => $request->deskripsi,
                    'tanggal' => $request->tanggal,
                    'lokasi' => $request->lokasi,
                    'created_by' => auth()->user()->username,
                    'updated_by' => auth()->user()->username,
                ];
                TugasModel::create($data);
                return redirect($this->button->formEtc($title))->with('success', 'Input data berhasil');
            }
        } else {
            $button = $this->button;
            $user = UserModel::all();
            return view('rapat.add', compact('title', 'button', 'user'));
        }
    }

    public function update(Request $request)
    {
        $title = 'Tugas';
        $rapat = TugasModel::findOrFail($request->id);
        $validatedData = $request->validate([
            'id_users' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'lokasi' => 'required',
        ]);

        if ($validatedData) {
            $rapat->update([
                'id_users' => $request->id_users,
                'deskripsi' => $request->deskripsi,
                'tanggal' => $request->tanggal,
                'lokasi' => $request->lokasi,
                'updated_by' => auth()->user()->username,
            ]);
            return redirect($this->button->formEtc($title) . '/detail/' . $request->id)->with('success', 'Edit data berhasil');
        }
    }

    public function delete($id)
    {
        $title = 'Tugas';
        TugasModel::findOrFail($id)->delete();
        return redirect($this->button->formEtc($title))->with('success', 'Hapus data berhasil');
    }

    public function detail($id)
    {
        $data = TugasModel::find($id);
        $user = UserModel::all();
        $button = $this->button;
        $title = 'Tugas';
        $cont = $this;
        return view('tugas.detail', compact('data', 'user', 'title', 'button', 'cont'));
    }

    public function update_foto(Request $request)
    {
        $uploadPath = public_path('upload/image/tugas/');

        if (!File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true, true);
        }
        $file = $request->file('foto');
        $extension = $file->getClientOriginalExtension();
        $rename = date('YmdHis') . $extension;

        $tugas = TugasModel::findOrFail($request->id);
        $tugas->update([
            'foto' => $rename,
            'updated_by' => auth()->user()->email,
        ]);
        return redirect($this->button->formEtc('Tugas') . '/detail/' . $request->id)->with('success', 'Edit foto berhasil');
    }

    public function update_catatan(Request $request)
    {
        $tugas = TugasModel::findOrFail($request->id);
        $tugas->update([
            'catatan' => $request->catatan,
            'updated_by' => auth()->user()->email,
        ]);
        return redirect($this->button->formEtc('Tugas') . '/detail/' . $request->id)->with('success', 'Edit catatan berhasil');
    }
}
