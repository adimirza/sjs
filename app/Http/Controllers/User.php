<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\DepartemenModel;
use App\Models\JabatanModel;
use App\Models\RoleModel;
use App\Models\UserModel as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class User extends Controller
{

    public $button;

    public function __construct()
    {
        $this->button = new GetButton;
    }

    public function index(Request $request)
    {
        $title = 'Pegawai';
        // $data = ModelsUser::select('users.id', 'name', 'email', 'jabatan.nama as nama_jabatan', 'bs_role.nama as nama_role')
        //                     ->leftJoin('jabatan', 'users.id_jabatan', '=', 'jabatan.id')
        //                     ->leftJoin('bs_role', 'jabatan.id_role', '=', 'bs_role.id')
        //                     ->get();
        if(auth()->user()->id_jabatan == '3'){
            $id_departemen = auth()->user()->id_departemen;
        }elseif($request->id_departemen){
            $id_departemen = $request->id_departemen;
        }else{
            $id_departemen = '';
        }
        if($id_departemen == 99){
            $data = ModelsUser::all();
        }else{
            $data = ModelsUser::where('id_departemen', $id_departemen)->get();
        }
        $departemen = DepartemenModel::all();
        $button = $this->button;
        return view('user.index', compact('data', 'departemen', 'id_departemen', 'title', 'button'));
    }

    public function info($id)
    {
        $title = 'Pegawai';
        $data = ModelsUser::find($id);
        $departemen = DepartemenModel::all();
        $jabatan = JabatanModel::all();
        $button = $this->button;
        return view('user.info', compact('data', 'title', 'button', 'departemen', 'jabatan'));
    }

    public function profil()
    {
        $title = 'Pegawai';
        $data = ModelsUser::find(auth()->user()->id);
        $departemen = DepartemenModel::all();
        $jabatan = JabatanModel::all();
        $button = $this->button;
        return view('user.info', compact('data', 'title', 'button', 'departemen', 'jabatan'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('POST')) {
            $validatedData = $request->validate([
                'id_pegawai' => 'required',
                'id_jabatan' => 'required',
                'id_departemen' => 'required',
                'username' => 'required|unique:users',
                'name' => 'required|max:255',
                'email' => 'required',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'no_hp' => 'required',
                'alamat' => 'required',
                'tanggal_masuk' => 'required',
                'tanggal_berakhir' => 'required',
                'status' => 'required',
            ]);

            if($request->file('foto')){
                $image = $request->file('foto');
                $imagename = $request->id . time() . '.' . $image->extension();
                $destinationPath = public_path('upload/image/profil');
    
                $img = Image::make($image->path());
                $img->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $imagename);
            }else{
                $imagename = 'default.png';
            }

            $password = Hash::make($request->id_pegawai);

            ModelsUser::create([
                'id_pegawai' => $request->id_pegawai,
                'id_jabatan' => $request->id_jabatan,
                'id_departemen' => $request->id_departemen,
                'username' => $request->username,
                'password' => $password,
                'name' => $request->name,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'tanggal_masuk' => $request->tanggal_masuk,
                'tanggal_berakhir' => $request->tanggal_berakhir,
                'status' => $request->status,
                'foto' => $imagename,
                'created_by' => auth()->user()->email,
                'updated_by' => auth()->user()->email,
            ]);
            return redirect($this->button->formEtc('Pegawai'))->with('success', 'Input data berhasil');
        } else {
            $title = 'Pegawai';
            $button = $this->button;
            $departemen = DepartemenModel::all();
            $jabatan = JabatanModel::all();
            return view('user.add', compact('title', 'departemen', 'jabatan', 'button'));
        }
    }

    public function update(Request $request, $id = null)
    {
        // if($request->isMethod('POST')){
        $user = ModelsUser::findOrFail($request->id);
        $validatedData = $request->validate([
            'id_pegawai' => 'required',
            'id_jabatan' => 'required',
            'id_departemen' => 'required',
            // 'username' => 'required|unique:users',
            'name' => 'required|max:255',
            'email' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'tanggal_masuk' => 'required',
            'tanggal_berakhir' => 'required',
            'status' => 'required',
        ]);

        if ($validatedData) {
            $user->update([
                'id_pegawai' => $request->id_pegawai,
                'id_jabatan' => $request->id_jabatan,
                'id_departemen' => $request->id_departemen,
                // 'username' => $request->id_pegawai,
                'name' => $request->name,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'tanggal_masuk' => $request->tanggal_masuk,
                'tanggal_berakhir' => $request->tanggal_berakhir,
                'status' => $request->status,
                'updated_by' => auth()->user()->email,
            ]);
            if(auth()->user()->id_jabatan == 4){
                return redirect($this->button->formEtc('Profil Pegawai'))->with('success', 'Edit data berhasil');
            }
            return redirect($this->button->formEtc('Pegawai') . '/info/' . $request->id)->with('success', 'Edit data berhasil');
        }
        // }else{
        //     $title = 'Pegawai';
        //     $data = ModelsUser::find($id);
        //     $role = RoleModel::all();
        //     $button = $this->button;
        //     return view('user.edit', compact('data', 'title', 'role', 'button'));
        // }
    }

    public function ganti_foto(Request $request)
    {
        $image = $request->file('foto');
        $imagename = $request->id . time() . '.' . $image->extension();
        $destinationPath = public_path('upload/image/profil');

        $img = Image::make($image->path());
        $img->resize(200, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imagename);

        $user = ModelsUser::findOrFail($request->id);
        $user->update([
            'foto' => $imagename,
            'updated_by' => auth()->user()->email,
        ]);
        if(auth()->user()->id_jabatan == 4){
            return redirect($this->button->formEtc('Profil Pegawai'))->with('success', 'Edit data berhasil');
        }
        return redirect($this->button->formEtc('Pegawai') . '/info/' . $request->id)->with('success', 'Edit data berhasil');
    }

    public function hapus_foto($id)
    {
        $user = ModelsUser::findOrFail($id);
        $user->update([
            'foto' => '',
            'updated_by' => auth()->user()->email,
        ]);
        return redirect($this->button->formEtc('Pegawai') . '/info/' . $id)->with('success', 'Edit data berhasil');
    }

    public function reset(Request $request)
    {
        $validatedData = $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
        ]);

        if ($validatedData) {
            if (!Hash::check($request->old_password, auth()->user()->password)) {
                return back()->with('error', "Current Password is Invalid");
            }
            $user = ModelsUser::findOrFail($request->id);
            $user->update([
                'password' => Hash::make($request->password),
                'updated_by' => auth()->user()->email,
            ]);
            return redirect($this->button->formEtc('Pegawai') . '/info/' . $request->id)->with('success', 'Reset password berhasil');
        }
        return redirect($this->button->formEtc('Pegawai') . '/info/' . $request->id)->with('error', 'Reset password gagal.');
    }

    public function delete($id)
    {
        ModelsUser::findOrFail($id)->delete();
        return redirect($this->button->formEtc('Pegawai'))->with('success', 'Hapus data berhasil');
    }
}
