<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\TopikSeModel;
use Illuminate\Http\Request;

class TopikSe extends Controller
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
        if($request->isMethod('POST')){
            $validatedData = $request->validate([
                'nama' => 'required|max:255',
            ]);

            if($validatedData){
                $data = [
                    'nama' => $request->nama,
                    'created_by' => auth()->user()->email,
                    'updated_by' => auth()->user()->email,
                ];
                TopikSeModel::create($data);
                return redirect($this->button->formEtc('Topik SE'))->with('success', 'Input data berhasil');
            }
        }else{
            $title = 'Topik SE';
            $button = $this->button;
            return view('topik_se.add', compact('title', 'button'));
        }
        
    }

    public function update(Request $request, $id=null)
    {
        if($request->isMethod('POST')){
            $user = TopikSeModel::findOrFail($request->id);
            $validatedData = $request->validate([
                'nama' => 'required|max:255',
            ]);

            if ($validatedData) {
                $user->update([
                    'nama'     => $request->nama,
                    'updated_by' => auth()->user()->email,
                ]);
                return redirect($this->button->formEtc('Topik SE'))->with('success', 'Edit data berhasil');
            }
        }else{
            $title = 'Topik SE';
            $button = $this->button;
            $data = TopikSeModel::find($id);
            return view('topik_se.edit', compact('data', 'title', 'button'));
        }
    }

    public function delete($id)
    {
        TopikSeModel::findOrFail($id)->delete();
        return redirect($this->button->formEtc('Topik SE'))->with('success', 'Hapus data berhasil');
    }
}
