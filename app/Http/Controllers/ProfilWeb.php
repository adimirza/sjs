<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Lib\GetProfilWeb;
use App\Models\ProfilWebModel;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfilWeb extends Controller
{

    public $button;

	public function __construct()
	{
		$this->button = new GetButton;
	}

    public function index()
    {
        $title = 'Profil Web';
        $button = $this->button;
        $profilWeb = new ProfilWebModel();
        $data = $profilWeb->getFillable();
        $getProfil = new GetProfilWeb;
        return view('profil_web.index', compact('data', 'title', 'button', 'getProfil'));
    }

    public function update(Request $request)
    {
        $id = $request->id;
        if($request->field != 'logo'){
            $field = $request->field;
            $value = $request->value;
        }else{
            $image = $request->file('value');
            $imagename = time().'.'.$image->extension();
            $destinationPath = public_path('upload/image/logo');
            
            $img = Image::make($image->path());
            $img->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$imagename);
            
            $field = $request->field;
            $value = $imagename;
        }
        
        if(is_null($id)){
            $data = [
                $field => $value,
                'created_by' => auth()->user()->email,
                'updated_by' => auth()->user()->email,
            ];
            ProfilWebModel::create($data);
        }else{
            $profil = ProfilWebModel::findOrFail($id);
            $profil->update([
                $field => $value,
                'updated_by' => auth()->user()->email,
            ]);
        }
        return redirect($this->button->formEtc('Profil Web'))->with('success', 'Edit data berhasil');
    }
}
