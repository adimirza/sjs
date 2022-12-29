<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\JabatanModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;

class Jabatan extends Controller
{

    public $button;

	public function __construct()
	{
		$this->button = new GetButton;
	}

    public function index()
    {
        $title = 'Jabatan';
        $data = JabatanModel::select('jabatan.id', 'jabatan.nama', 'id_role', 'bs_role.nama as nama_role')
                                ->join('bs_role', 'bs_role.id', '=', 'jabatan.id_role')->get();
        $button = $this->button;
        return view('jabatan.index', compact('data', 'title', 'button'));
    }

    public function store(Request $request)
    {
        if($request->isMethod('POST')){
            $validatedData = $request->validate([
                'nama' => 'required|max:255',
                'id_role' => 'required'
            ]);

            if($validatedData){
                $data = [
                    'nama' => $request->nama,
                    'id_role' => $request->id_role,
                    'created_by' => auth()->user()->email,
                    'updated_by' => auth()->user()->email,
                ];
                JabatanModel::create($data);
                return redirect($this->button->formEtc('Jabatan'))->with('success', 'Input data berhasil');
            }
        }else{
            $title = 'Jabatan';
            $button = $this->button;
            $role = RoleModel::all();
            return view('jabatan.add', compact('title', 'button', 'role'));
        }
        
    }

    public function update(Request $request, $id=null)
    {
        if($request->isMethod('POST')){
            $user = JabatanModel::findOrFail($request->id);
            $validatedData = $request->validate([
                'nama' => 'required|max:255',
                'id_role' => 'required'
            ]);

            if ($validatedData) {
                $user->update([
                    'nama'     => $request->nama,
                    'id_role'     => $request->id_role,
                    'updated_by' => auth()->user()->email,
                ]);
                return redirect($this->button->formEtc('Jabatan'))->with('success', 'Edit data berhasil');
            }
        }else{
            $title = 'Jabatan';
            $button = $this->button;
            $data = JabatanModel::find($id);
            $role = RoleModel::all();
            return view('jabatan.edit', compact('data', 'title', 'button', 'role'));
        }
    }

    public function delete($id)
    {
        JabatanModel::findOrFail($id)->delete();
        return redirect($this->button->formEtc('Jabatan'))->with('success', 'Hapus data berhasil');
    }
}
