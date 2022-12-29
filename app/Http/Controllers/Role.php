<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\RoleModel;
use Illuminate\Http\Request;

class Role extends Controller
{

    public $button;

	public function __construct()
	{
		$this->button = new GetButton;
	}

    public function index()
    {
        $title = 'Role';
        $data = RoleModel::all();
        $button = $this->button;
        return view('role.index', compact('data', 'title', 'button'));
    }

    public function store(Request $request)
    {
        if($request->isMethod('POST')){
            $validatedData = $request->validate([
                'nama' => 'required|max:255',
                'deskripsi' => 'required',
            ]);

            if($validatedData){
                $data = [
                    'nama' => $request->nama,
                    'deskripsi' => $request->deskripsi,
                    'created_by' => auth()->user()->email,
                    'updated_by' => auth()->user()->email,
                ];
                RoleModel::create($data);
                return redirect($this->button->formEtc('Role'))->with('success', 'Input data berhasil');
            }
        }else{
            $title = 'Role';
            $button = $this->button;
            return view('role.add', compact('title', 'button'));
        }
        
    }

    public function update(Request $request, $id=null)
    {
        if($request->isMethod('POST')){
            $user = RoleModel::findOrFail($request->id);
            $validatedData = $request->validate([
                'nama' => 'required|max:255',
                'deskripsi' => 'required',
            ]);

            if ($validatedData) {
                $user->update([
                    'nama'     => $request->nama,
                    'deskripsi'   => $request->deskripsi,
                    'updated_by' => auth()->user()->email,
                ]);
                return redirect($this->button->formEtc('Role'))->with('success', 'Edit data berhasil');
            }
        }else{
            $title = 'Role';
            $button = $this->button;
            $data = RoleModel::find($id);
            return view('role.edit', compact('data', 'title', 'button'));
        }
    }

    public function delete($id)
    {
        RoleModel::findOrFail($id)->delete();
        return redirect($this->button->formEtc('Role'))->with('success', 'Hapus data berhasil');
    }
}
