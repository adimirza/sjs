<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\AtributModel;
use App\Models\KelengkapanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class Kelengkapan extends Controller
{

    public $button;

    public function __construct()
    {
        $this->button = new GetButton;
    }

    public function index($id)
    {
        $title = 'Kelengkapan';
        $user = UserModel::find($id);
        $button = $this->button;
        $cont = $this;
        $atribut = AtributModel::where('status', 1)->get();
        return view('kelengkapan.index', compact('title', 'user', 'atribut', 'button', 'cont'));
    }

    public function index_staf()
    {
        $title = 'Kelengkapan';
        $button = $this->button;
        $cont = $this;
        $atribut = KelengkapanModel::select('kelengkapan.id', 'atribut', 'check_admin', 'check_user', 'keterangan')
                                    ->where(['id_users' => auth()->user()->id, 'atribut.status' => 1])
                                    ->join('atribut', 'atribut.id', '=', 'kelengkapan.id_atribut')
                                    ->get();
        return view('kelengkapan.index_staf', compact('title', 'atribut', 'button', 'cont'));
    }

    public function update(Request $request)
    {
        // print_r($request->all());
        // die;
        for ($i = 1; $i <= $request->jumlah; $i++) {
            $kelengkapan = KelengkapanModel::findOrFail($request->id[$i]);
            $check_user = 1;
            if (!isset($request->check_user[$i])) {
                $check_user = 0;
            }
            $data = [
                // 'id_atribut' => $request->id_atribut[$i],
                // 'id_users' => $id_users,
                'check_user' => $check_user,
                'keterangan' => $request->keterangan[$i],
                'created_by' => auth()->user()->email,
                'updated_by' => auth()->user()->email,
            ];
            $kelengkapan->update($data);
        }
        return redirect($this->button->formEtc('Kelengkapan Pegawai'))->with('success', 'Input data berhasil');
    }

    public function store(Request $request, $id_users)
    {
        for ($i = 1; $i <= $request->jumlah; $i++) {
            $kelengkapan = KelengkapanModel::where(['id_atribut' => $request->id_atribut[$i], 'id_users' => $id_users])->first();
            $check_admin = 1;
            if (!isset($request->check_admin[$i])) {
                $check_admin = 0;
            }
            $data = [
                'id_atribut' => $request->id_atribut[$i],
                'id_users' => $id_users,
                'check_admin' => $check_admin,
                'created_by' => auth()->user()->email,
                'updated_by' => auth()->user()->email,
            ];
            if ($kelengkapan) {
                $kelengkapan->update($data);
            } else {
                KelengkapanModel::create($data);
            }
        }
        return redirect($this->button->formEtc('Kelengkapan') . '/' . $id_users)->with('success', 'Input data berhasil');
    }

    public function getkelengkapan($id_users, $id_atribut)
    {
        $result = [
            'check_admin' => 0,
            'check_user' => 0,
            'keterangan' => ''
        ];
        $kelengkapan = KelengkapanModel::where(['id_atribut' => $id_atribut, 'id_users' => $id_users])->first();
        if ($kelengkapan) {
            $result = [
                'check_admin' => $kelengkapan['check_admin'],
                'check_user' => $kelengkapan['check_user'],
                'keterangan' => $kelengkapan['keterangan']
            ];
        }
        return $result;
    }
}
