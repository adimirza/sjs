<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\SoalModel;
use App\Models\SuratModel;
use App\Models\TopikSeModel;
use Illuminate\Http\Request;

class Soal extends Controller
{

    public $button;

    public function __construct()
    {
        $this->button = new GetButton;
    }

    public function index()
    {
        $title = 'Topik SE';
        $data = TopikSeModel::all();
        $button = $this->button;
        return view('topik_se.index', compact('data', 'title', 'button'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_surat' => 'required',
            'pertanyaan' => 'required',
            // 'pilihan[]' => 'required',
            'kunci_jawaban' => 'required',
        ]);
        $surat = SuratModel::find($request->id_surat);
        if ($surat['ditujukan'] == '0') {
            $title = 'Surat Edaran Umum';
        } else {
            $title = 'Surat Edaran Khusus';
        }
        $pilihan = json_encode($request->pilihan);
        if ($validatedData) {
            $data = [
                'id_surat' => $request->id_surat,
                'pertanyaan' => $request->pertanyaan,
                'pilihan' => $pilihan,
                'kunci_jawaban' => $request->kunci_jawaban,
                'created_by' => auth()->user()->email,
                'updated_by' => auth()->user()->email,
            ];
            SoalModel::create($data);
            return redirect($this->button->formEtc($title) . '/detail/' . $request->id_surat.'?tab=soal')->with('success', 'Input data berhasil');
        }
    }

    public function getSoal(Request $request)
    {
        $soal = SoalModel::find($request->id);
        $result['id'] = '';
        $result['pertanyaan'] = '';
        $result['pilihan_a'] = '';
        $result['pilihan_b'] = '';
        $result['pilihan_c'] = '';
        $result['pilihan_d'] = '';
        $result['kunci_jawaban'] = '';
        if ($soal) {
            $result['id'] = $soal->id;
            $result['pertanyaan'] = $soal->pertanyaan;
            $result['pilihan_a'] = $soal->pilihan_ganda($soal->id)[0];
            $result['pilihan_b'] = $soal->pilihan_ganda($soal->id)[1];
            $result['pilihan_c'] = $soal->pilihan_ganda($soal->id)[2];
            $result['pilihan_d'] = $soal->pilihan_ganda($soal->id)[3];
            $result['kunci_jawaban'] = $soal->kunci_jawaban;
        }
        return json_encode($result);
    }

    public function update(Request $request)
    {
        $user = SoalModel::findOrFail($request->id);
        $validatedData = $request->validate([
            'id_surat' => 'required',
            'pertanyaan' => 'required',
            // 'pilihan[]' => 'required',
            'kunci_jawaban' => 'required',
        ]);
        $surat = SuratModel::find($request->id_surat);
        if ($surat['ditujukan'] == '0') {
            $title = 'Surat Edaran Umum';
        } else {
            $title = 'Surat Edaran Khusus';
        }
        $pilihan = json_encode($request->pilihan);

        if ($validatedData) {
            $user->update([
                'id_surat' => $request->id_surat,
                'pertanyaan' => $request->pertanyaan,
                'pilihan' => $pilihan,
                'kunci_jawaban' => $request->kunci_jawaban,
                'updated_by' => auth()->user()->email,
            ]);
            return redirect($this->button->formEtc($title) . '/detail/' . $request->id_surat.'?tab=soal')->with('success', 'Edit data berhasil');
        }
    }

    public function delete($id, $id_surat)
    {
        $soal = SoalModel::findOrFail($id);
        $surat = SuratModel::find($id_surat);
        if ($surat['ditujukan'] == '0') {
            $title = 'Surat Edaran Umum';
        } else {
            $title = 'Surat Edaran Khusus';
        }
        $soal->delete();
        return redirect($this->button->formEtc($title) . '/detail/' . $surat->id.'?tab=soal')->with('success', 'Hapus data berhasil');
    }
}
