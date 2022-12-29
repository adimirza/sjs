<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\DepartemenModel;
use Illuminate\Http\Request;

class Departemen extends Controller
{

    public $button;

	public function __construct()
	{
		$this->button = new GetButton;
	}

    public function index()
    {
        $title = 'Departemen / Divisi';
        $data = DepartemenModel::all();
        $button = $this->button;
        return view('departemen.index', compact('data', 'title', 'button'));
    }

    public function store(Request $request)
    {
        if($request->isMethod('POST')){
            $validatedData = $request->validate([
                'nama' => 'required|max:255',
                'kategori' => 'required',
            ]);

            if($validatedData){
                $data = [
                    'nama' => $request->nama,
                    'kategori' => $request->kategori,
                    'created_by' => auth()->user()->email,
                    'updated_by' => auth()->user()->email,
                ];
                DepartemenModel::create($data);
                return redirect($this->button->formEtc('Departemen / Divisi'))->with('success', 'Input data berhasil');
            }
        }else{
            $title = 'Departemen / Divisi';
            $button = $this->button;
            return view('departemen.add', compact('title', 'button'));
        }
        
    }

    public function update(Request $request, $id=null)
    {
        if($request->isMethod('POST')){
            $user = DepartemenModel::findOrFail($request->id);
            $validatedData = $request->validate([
                'nama' => 'required|max:255',
                'kategori' => 'required',
            ]);

            if ($validatedData) {
                $user->update([
                    'nama'     => $request->nama,
                    'kategori'   => $request->kategori,
                    'updated_by' => auth()->user()->email,
                ]);
                return redirect($this->button->formEtc('Departemen / Divisi'))->with('success', 'Edit data berhasil');
            }
        }else{
            $title = 'Departemen / Divisi';
            $button = $this->button;
            $data = DepartemenModel::find($id);
            return view('departemen.edit', compact('data', 'title', 'button'));
        }
    }

    public function delete($id)
    {
        DepartemenModel::findOrFail($id)->delete();
        return redirect($this->button->formEtc('Departemen / Divisi'))->with('success', 'Hapus data berhasil');
    }
}
