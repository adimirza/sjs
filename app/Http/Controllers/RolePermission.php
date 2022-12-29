<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\MenuModel;
use App\Models\MenuPermissionModel;
use App\Models\RoleModel;
use App\Models\RolePermissionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolePermission extends Controller
{

    public $button;

	public function __construct()
	{
		$this->button = new GetButton;
	}

    public function index($id)
    {
        $title = 'Role Permission';
        $role = RoleModel::find($id);
        $menu = MenuModel::all();
        $button = $this->button;
        $menu_permission = MenuPermissionModel::all();
        return view('role_permission.index', compact('title', 'menu', 'role', 'menu_permission', 'button'));
    }

    public function store(Request $request)
    {
        DB::table('bs_role_permission')->where('id_role', '=', $request->id_role)->delete();
        $permission = DB::table('bs_role_permission')->where('id_role', '=', $request->id_role)->get();

        if(count($permission) == 0){
            foreach($request->id_permission as $per){
                $data = [
                    'id_menu_permission' => $per,
                    'id_role' => $request->id_role,
                    'created_by' => auth()->user()->email,
                    'updated_by' => auth()->user()->email,
                ];
                RolePermissionModel::create($data);
            }
            return redirect($this->button->formEtc('Role Permission').'/'.$request->id_role)->with('success', 'Input data berhasil');
        }else{
            return redirect($this->button->formEtc('Role Permission').'/'.$request->id_role)->with('error', 'Terjadi kesalahan');
        }
    }

    public function getPermission($id_role, $id_menu_permission)
    {
        $role_permission = RolePermissionModel::where(['id_role' => $id_role, 'id_menu_permission' => $id_menu_permission])->first();
        if($role_permission){
            return true;
        }else{
            return false;
        }
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
        return redirect($this->button->formEtc('Role Permission').'/'.$permission['id_menu'])->with('success', 'Ubah status berhasil');
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
        return redirect($this->button->formEtc('Role Permission').'/'.$id)->with('success', 'Refresh data berhasil');
    }
}
