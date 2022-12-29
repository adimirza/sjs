<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\MenuHeadingModel;
use Illuminate\Http\Request;

class MenuHeading extends Controller
{

    public $button;

	public function __construct()
	{
		$this->button = new GetButton;
	}

    public function index()
    {
        $title = 'Menu Heading';
        $button = $this->button;
        $data = MenuHeadingModel::all();
        return view('menu_heading.index', compact('data', 'title', 'button'));
    }

    public function store(Request $request)
    {
        
        if($request->isMethod('POST')){
            $validatedData = $request->validate([
                'nama_heading' => 'required|max:255'
            ]);

            if($validatedData){
                $data = [
                    'nama_heading' => $request->nama_heading,
                    'created_by' => auth()->user()->email,
                    'updated_by' => auth()->user()->email,
                ];
                MenuHeadingModel::create($data);
                return redirect($this->button->formEtc('Menu Heading'))->with('success', 'Input data berhasil');
            }
        }else{
            $title = 'Menu Heading';
            $button = $this->button;
            return view('menu_heading.add', compact('title', 'button'));
        }
        
    }

    public function update(Request $request, $id=null)
    {
        if($request->isMethod('POST')){
            $user = MenuHeadingModel::findOrFail($request->id);
            $validatedData = $request->validate([
                'nama_heading' => 'required|max:255'
            ]);

            if ($validatedData) {
                $user->update([
                    'nama_heading' => $request->nama_heading,
                    'updated_by' => auth()->user()->email,
                ]);
                return redirect($this->button->formEtc('Menu Heading'))->with('success', 'Edit data berhasil');
            }
        }else{
            $title = 'Menu Heading';
            $button = $this->button;
            $data = MenuHeadingModel::find($id);
            return view('menu_heading.edit', compact('data', 'title', 'button'));
        }
    }

    public function delete($id)
    {
        MenuHeadingModel::findOrFail($id)->delete();
        return redirect($this->button->formEtc('Menu Heading'))->with('success', 'Hapus data berhasil');
    }
}
