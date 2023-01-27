<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\DepartemenModel;
use App\Models\TugasModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
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
        $title = 'Tugas';
        $data = TugasModel::orderBy("tanggal", "DESC")->get();
        $button = $this->button;
        $cont = $this;
        return view('tugas.index', compact('data', 'title', 'button', 'cont'));
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
                'status' => 'required',
            ]);
            if ($validatedData) {
                $data = [
                    'id_users' => $request->id_users,
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
        $title = 'Tugas';
        $rapat = TugasModel::findOrFail($request->id);
        $validatedData = $request->validate([
            'id_users' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'lokasi' => 'required',
            'status' => 'status',
        ]);

        if ($validatedData) {
            $rapat->update([
                'id_users' => $request->id_users,
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
        $title = 'Tugas';
        TugasModel::findOrFail($id)->delete();
        return redirect($this->button->formEtc($title))->with('success', 'Hapus data berhasil');
    }

    public function detail($id)
    {
        $data = TugasModel::find($id);
        $user = UserModel::all();
        $departemen = DepartemenModel::all();
        $button = $this->button;
        $title = 'Tugas';
        $cont = $this;
        return view('tugas.detail', compact('data', 'user', 'departemen', 'title', 'button', 'cont'));
    }

    public function update_foto(Request $request)
    {
        $image = $request->file('foto');
        $imagename = $request->id . time() . '.' . $image->extension();
        $destinationPath = public_path('upload/image/tugas');

        $img = Image::make($image->path());
        $img->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imagename);

        $tugas = TugasModel::findOrFail($request->id);
        $tugas->update([
            'foto' => $imagename,
            'updated_by' => auth()->user()->username,
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

    public function getdata(Request $request)
    {
        $user = UserModel::where('id_departemen', $request->id)->get();
        return json_encode($user);
    }
}
