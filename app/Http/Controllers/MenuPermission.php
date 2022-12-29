<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\MenuModel;
use App\Models\MenuPermissionModel;
use Illuminate\Http\Request;

class MenuPermission extends Controller
{

    public $button;

	public function __construct()
	{
		$this->button = new GetButton;
	}

    public function index($id)
    {
        $title = 'Menu Permission';
        $menu = MenuModel::find($id);
        $button = $this->button;
        $data = MenuPermissionModel::where('id_menu', '=', $id)->get();
        return view('menu_permission.index', compact('data', 'title', 'menu', 'button'));
    }

    public function status(Request $request)
    {
        $permission = MenuPermissionModel::findOrFail($request->id);
        $st_ubah = 1;
        if($permission['is_active'] == 1){
            $st_ubah = 0;
        }
        $permission->update([
            'is_active' => $st_ubah,
            'updated_by' => auth()->user()->email,
        ]);
        return redirect($this->button->formEtc('Menu Permission').'/'.$permission['id_menu'])->with('success', 'Ubah status berhasil');
    }

    public function refresh($id)
    {
        $permission = MenuPermissionModel::PERMISSION;
        $check = MenuPermissionModel::where('id_menu', $id)->get();
        foreach($permission as $per){
            $menu_permission = MenuPermissionModel::where(['id_menu' => $id, 'permission' => $per])->first();
            if(!$menu_permission){
                $data_per = [
                    'id_menu' => $id,
                    'permission' => $per,
                    'is_active' => 1,
                    'created_by' => auth()->user()->email,
                    'updated_by' => auth()->user()->email,
                ];
                MenuPermissionModel::create($data_per);
            }
        }
        foreach($check as $ck){
            if(!in_array($ck['permission'], $permission)){
                MenuPermissionModel::findOrFail($ck['id'])->delete();
            }
        }
        return redirect($this->button->formEtc('Menu Permission').'/'.$id)->with('success', 'Refresh data berhasil');
    }
}
