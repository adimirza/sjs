<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\AtributModel;
use Illuminate\Http\Request;

class Atribut extends Controller
{

    public $button;

	public function __construct()
	{
		$this->button = new GetButton;
	}

    public function index()
    {
        $title = 'Atribut';
        $data = AtributModel::all();
        $button = $this->button;
        return view('atribut.index', compact('data', 'title', 'button'));
    }

    public function store(Request $request)
    {
        if($request->isMethod('POST')){
            $validatedData = $request->validate([
                'atribut' => 'required|max:255',
                'status' => 'required'
            ]);

            if($validatedData){
                $data = [
                    'atribut' => $request->atribut,
                    'status' => $request->status,
                    'created_by' => auth()->user()->email,
                    'updated_by' => auth()->user()->email,
                ];
                AtributModel::create($data);
                return redirect($this->button->formEtc('Atribut'))->with('success', 'Input data berhasil');
            }
        }else{
            $title = 'Atribut';
            $button = $this->button;
            return view('atribut.add', compact('title', 'button'));
        }
        
    }

    public function update(Request $request, $id=null)
    {
        if($request->isMethod('POST')){
            $user = AtributModel::findOrFail($request->id);
            $validatedData = $request->validate([
                'atribut' => 'required|max:255',
                'status' => 'required'
            ]);

            if ($validatedData) {
                $user->update([
                    'atribut' => $request->atribut,
                    'status' => $request->status,
                    'updated_by' => auth()->user()->email,
                ]);
                return redirect($this->button->formEtc('Atribut'))->with('success', 'Edit data berhasil');
            }
        }else{
            $title = 'Atribut';
            $button = $this->button;
            $data = AtributModel::find($id);
            return view('atribut.edit', compact('data', 'title', 'button'));
        }
    }

    public function delete($id)
    {
        AtributModel::findOrFail($id)->delete();
        return redirect($this->button->formEtc('Topik SE'))->with('success', 'Hapus data berhasil');
    }
}
