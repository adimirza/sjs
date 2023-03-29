<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\TeguranModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Teguran extends Controller
{

    public $button;

    public function __construct()
    {
        $this->button = new GetButton;
    }

    public function index($id = null)
    {
        if(auth()->user()->id_jabatan == 4){
            $id = auth()->user()->id;
        }
        $title = 'Teguran';
        $data = TeguranModel::where('id_users', $id)->orderBy('tanggal')->get();
        $user = UserModel::find($id);
        $button = $this->button;
        return view('teguran.index', compact('data', 'user', 'title', 'button'));
    }

    public function store(Request $request, $id_user)
    {
        if ($request->isMethod('POST')) {
            $validatedData = $request->validate([
                'kategori' => 'required',
                'keterangan' => 'required',
                'file_surat' => 'required',
                'tanggal' => 'required',
            ]);

            if ($validatedData) {
                $uploadPath = public_path('upload/surat/teguran/');

                if (!File::isDirectory($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true, true);
                }
                $file = $request->file('file_surat');
                $extension = $file->getClientOriginalExtension();
                $rename = date('YmdHis') . '_' . $id_user . '_' . $request->kategori . '.' . $extension;

                if ($file->move($uploadPath, $rename)) {
                    $data = [
                        'id_users' => $id_user,
                        'kategori' => $request->kategori,
                        'keterangan' => $request->keterangan,
                        'file_surat' => $rename,
                        'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
                        'created_by' => auth()->user()->email,
                        'updated_by' => auth()->user()->email,
                    ];
                    TeguranModel::create($data);
                    return redirect($this->button->formEtc('Teguran') . '/' . $id_user)->with('success', 'Input data berhasil');
                }
            }
        } else {
            $title = 'Teguran';
            $button = $this->button;
            return view('teguran.add', compact('title', 'id_user', 'button'));
        }
    }

    public function update(Request $request, $id = null)
    {
        if ($request->isMethod('POST')) {
            $user = TeguranModel::findOrFail($request->id);
            $validatedData = $request->validate([
                'kategori' => 'required',
                'keterangan' => 'required',
                'tanggal' => 'required',
            ]);

            $rename = $request->file_surat_old;

            if($request->file_surat){
                $uploadPath = public_path('upload/surat/teguran/');

                if (!File::isDirectory($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true, true);
                }
                $file = $request->file('file_surat');
                $extension = $file->getClientOriginalExtension();
                $rename = date('YmdHis') . '_' . $request->id_users . '_' . $request->kategori . '.' . $extension;
                $file->move($uploadPath, $rename);
            }

            if ($validatedData) {
                $user->update([
                    'id_users' => $request->id_users,
                    'kategori' => $request->kategori,
                    'keterangan' => $request->keterangan,
                    'file_surat' => $rename,
                    'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
                    'updated_by' => auth()->user()->email,
                ]);
                return redirect($this->button->formEtc('Teguran') . '/' . $request->id_users)->with('success', 'Edit data berhasil');
            }
        } else {
            $title = 'Teguran';
            $button = $this->button;
            $data = TeguranModel::find($id);
            return view('teguran.edit', compact('data', 'title', 'button'));
        }
    }

    public function ganti_surat(Request $request)
    {
        $surat = TeguranModel::findOrFail($request->id);
        $uploadPath = public_path('upload/surat/teguran/');

        if (!File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true, true);
        }
        $file = $request->file('file_surat');
        $extension = $file->getClientOriginalExtension();
        $rename = date('YmdHis') . '_' . $surat->id_users . '_' . $surat->kategori . '.' . $extension;

        $surat->update([
            'file_surat' => $rename,
            'updated_by' => auth()->user()->email,
        ]);
        return redirect($this->button->formEtc('Teguran') . '/' . $surat->id_users)->with('success', 'Edit data berhasil');
    }

    public function delete($id, $id_users)
    {
        $teguran = TeguranModel::findOrFail($id);
        if(File::exists(public_path('upload/surat/teguran/'.$teguran->file_surat))){
            File::delete(public_path('upload/surat/teguran/'.$teguran->file_surat));
            $teguran->delete();
        }
        return redirect($this->button->formEtc('Teguran') . '/' . $id_users)->with('success', 'Hapus data berhasil');
    }
}
