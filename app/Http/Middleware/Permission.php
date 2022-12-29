<?php

namespace App\Http\Middleware;

use App\Models\JabatanModel;
use App\Models\MenuPermissionModel;
use App\Models\RolePermissionModel;
use Closure;
use Illuminate\Http\Request;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $nama, $per)
    {
        $jabatan = JabatanModel::find(auth()->user()->id_jabatan);
        $role = $jabatan['id_role'];
        $check_permission = MenuPermissionModel::selectRaw('bs_menu_permission.id as id, permission, is_active, id_menu, bs_menu.nama as nama, uri, id_role')
                                                ->join('bs_menu', 'bs_menu.id', '=', 'bs_menu_permission.id_menu')
                                                ->join('bs_role_permission', 'bs_role_permission.id_menu_permission', '=', 'bs_menu_permission.id')
                                                ->whereRaw("UPPER(bs_menu.nama) = '".strtoupper($nama)."' AND permission = '$per' AND id_role = $role")->first();
        if($check_permission){
            return $next($request);
        }
        $title = 'None';
        return response()->view('access_denied.index', compact('title'));
    }
}
