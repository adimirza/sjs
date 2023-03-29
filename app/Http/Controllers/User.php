<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\DepartemenModel;
use App\Models\HistoryNilaiModel;
use App\Models\JabatanModel;
use App\Models\LogSuratModel;
use App\Models\RoleModel;
use App\Models\SuratModel;
use App\Models\UserModel as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
        $uri = 'pegawai';
        $data = ModelsUser::find($id);
        $departemen = DepartemenModel::all();
        $jabatan = JabatanModel::all();
        $button = $this->button;
        $jml_paham_umum = HistoryNilaiModel::select("id_users")
                                ->join("surat", "history_nilai.id_surat", "=", "surat.id")
                                ->where(["nilai" => "nilai_max", 
                                         "id_users" => $data->id,
                                         "ditujukan" => 0])
                                ->distinct()->count();
        $jml_paham_divisi = HistoryNilaiModel::select("id_users")
                            ->join("surat", "history_nilai.id_surat", "=", "surat.id")
                            ->whereRaw("nilai = nilai_max AND ".
                                        "id_users = ".$data->id." AND ".
                                        "ditujukan = ".$data->id_departemen)
                            ->distinct()->count();
        $jml_umum = SuratModel::where("ditujukan", 0)->count();
        $jml_divisi = SuratModel::where("ditujukan", $data->id_departemen)->count();
        $log = LogSuratModel::where("id_users", $data->id)->get();
        return view('user.info', compact('data', 'title', 'button', 'departemen', 'jabatan', 'jml_paham_umum',
                                         'jml_paham_divisi', 'jml_umum', 'jml_divisi', 'log', 'uri'));
    }

    public function profil()
    {
        $title = 'Pegawai';
        $uri = 'profil_pegawai';
        $data = ModelsUser::find(auth()->user()->id);
        $departemen = DepartemenModel::all();
        $jabatan = JabatanModel::all();
        $button = $this->button;
        $jml_paham_umum = HistoryNilaiModel::select("id_users")
                                ->join("surat", "history_nilai.id_surat", "=", "surat.id")
                                ->where(["nilai" => "nilai_max", 
                                         "id_users" => $data->id,
                                         "ditujukan" => 0])
                                ->distinct()->count();
        $jml_paham_divisi = HistoryNilaiModel::select("id_users")
                            ->join("surat", "history_nilai.id_surat", "=", "surat.id")
                            ->whereRaw("nilai = nilai_max AND ".
                                        "id_users = ".$data->id." AND ".
                                        "ditujukan = ".$data->id_departemen)
                            ->distinct()->count();
        $jml_umum = SuratModel::where("ditujukan", 0)->count();
        $jml_divisi = SuratModel::where("ditujukan", $data->id_departemen)->count();
        $log = LogSuratModel::where("id_users", $data->id)->get();
        return view('user.info', compact('data', 'title', 'button', 'departemen', 'jabatan', 'jml_paham_umum',
                                         'jml_paham_divisi', 'jml_umum', 'jml_divisi', 'log', 'uri'));
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
                'no_bpjs' => 'required',
                'tanggal_masuk' => 'required',
                'tanggal_berakhir' => 'required',
                'status' => 'required',
            ]);

            if($request->file('foto')){
                $image = $request->file('foto');
                $imagename = $request->id . time() . '.' . $image->extension();
                $destinationPath = public_path('upload/image/profil');
    
                $img = Image::make($image->path());
                $img->resize(800, null, function ($constraint) {
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
                'no_bpjs' => $request->no_bpjs,
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
            'no_bpjs' => 'required',
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
                'no_bpjs' => $request->no_bpjs,
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
        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true, true);
        }
        $img = Image::make($image->path());
        $img->resize(800, null, function ($constraint) {
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

    public function upload_cv(Request $request)
    {
        $uploadPath = public_path('upload/file_cv/');

        if (!File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true, true);
        }
        $file = $request->file('file_surat');
        $extension = $file->getClientOriginalExtension();
        $rename = $request->id.'_'.date('YmdHis') . $extension;

        $surat = ModelsUser::findOrFail($request->id);
        $surat->update([
            'file_cv' => $rename,
            'updated_by' => auth()->user()->email,
        ]);
        return redirect($this->button->formEtc('Pegawai') . '/info/' . $request->id)->with('success', 'Edit data berhasil');
    }

    public function hapus_foto($id = null)
    {
        if(auth()->user()->id_jabatan == 4){
            $id = auth()->user()->id;
        }
        $user = ModelsUser::findOrFail($id);
        $user->update([
            'foto' => '',
            'updated_by' => auth()->user()->email,
        ]);
        if(auth()->user()->id_jabatan == 4){
            return redirect($this->button->formEtc('Profil Pegawai'))->with('success', 'Edit data berhasil');
        }
        return redirect($this->button->formEtc('Pegawai') . '/info/' . $id)->with('success', 'Edit data berhasil');
    }

    public function reset(Request $request)
    {
        $validatedData = $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
        ]);
        $url = '/profil_pegawai';
        if($request->uri == 'pegawai'){
            $url = '/info/' . $request->id;
        }

        if ($validatedData) {
            if (!Hash::check($request->old_password, auth()->user()->password)) {
                return back()->with('error', "Current Password is Invalid");
            }
            $user = ModelsUser::findOrFail($request->id);
            $user->update([
                'password' => Hash::make($request->password),
                'updated_by' => auth()->user()->email,
            ]);
            return redirect($this->button->formEtc('Pegawai') . $url)->with('success', 'Reset password berhasil');
        }
        return redirect($this->button->formEtc('Pegawai') . $url)->with('error', 'Reset password gagal.');
    }

    public function delete($id)
    {
        ModelsUser::findOrFail($id)->delete();
        return redirect($this->button->formEtc('Pegawai'))->with('success', 'Hapus data berhasil');
    }
}
