<?php

namespace App\Lib;

use App\Models\JabatanModel;
use App\Models\MenuPermissionModel;

class GetButton
{
  function btnRead($menu, $id=null)
  {
    $role = auth()->user()->jabatan->id_role;
    $html_out = '';
    $button = MenuPermissionModel::selectRaw('bs_menu.id as id, bs_menu.nama as nama, uri, url, permission, id_role')
                      ->join('bs_menu', 'bs_menu.id', '=', 'bs_menu_permission.id_menu')
                      ->join('bs_role_permission', 'bs_role_permission.id_menu_permission', '=', 'bs_menu_permission.id')
                      ->whereRaw("is_active = 1 AND nama = '$menu' AND id_role = $role AND permission = 'read'")->first();
    if(!is_null($id)){
      $id = '/'.$id;
    }
    if($button){
      $url = url('/'.$button['uri'].$id);
      $html_out = '<a href="'.$url.'" class="btn btn-info btn-sm">'.$button['nama'].'</a>';
    }
    
    return $html_out;
  }

  function btnCreate($menu)
  {
    $role = auth()->user()->jabatan->id_role;
    $html_out = '';
    $button = MenuPermissionModel::selectRaw('bs_menu.id as id, bs_menu.nama as nama, uri, url, permission, id_role')
                      ->join('bs_menu', 'bs_menu.id', '=', 'bs_menu_permission.id_menu')
                      ->join('bs_role_permission', 'bs_role_permission.id_menu_permission', '=', 'bs_menu_permission.id')
                      ->whereRaw("is_active = 1 AND nama = '$menu' AND id_role = $role AND permission = 'create'")->first();
    if($button){
      $url = url('/'.$button['uri'].'/add');
      $html_out = '<a href="'.$url.'" class="btn btn-success btn-sm">Tambah</a>';
    }
    
    return $html_out;
  }

  function btnEdit($menu, $id=null)
  {
    $role = auth()->user()->jabatan->id_role;
    $html_out = '';
    $button = MenuPermissionModel::selectRaw('bs_menu.id as id, bs_menu.nama as nama, uri, url, permission, id_role')
                      ->join('bs_menu', 'bs_menu.id', '=', 'bs_menu_permission.id_menu')
                      ->join('bs_role_permission', 'bs_role_permission.id_menu_permission', '=', 'bs_menu_permission.id')
                      ->whereRaw("is_active = 1 AND nama = '$menu' AND id_role = $role AND permission = 'update'")->first();
    if(!is_null($id)){
      $id = '/'.$id;
    }
    if($button){
      $url = url('/'.$button['uri'].'/edit'.$id);
      $html_out = '<a href="'.$url.'" class="btn btn-warning btn-sm">Ubah</a>';
    }
    
    return $html_out;
  }

  function btnDelete($menu)
  {
    $role = auth()->user()->jabatan->id_role;
    $html_out = '';
    $button = MenuPermissionModel::selectRaw('bs_menu.id as id, bs_menu.nama as nama, uri, url, permission, id_role')
                      ->join('bs_menu', 'bs_menu.id', '=', 'bs_menu_permission.id_menu')
                      ->join('bs_role_permission', 'bs_role_permission.id_menu_permission', '=', 'bs_menu_permission.id')
                      ->whereRaw("is_active = 1 AND nama = '$menu' AND id_role = $role AND permission = 'delete'")->first();
    if($button){
      $html_out = '<button type="submit" class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip">Hapus</button>';
    }
    return $html_out;
  }

  function formAdd($menu)
  {
    $role = auth()->user()->jabatan->id_role;
    $url = '';
    $getmenu = MenuPermissionModel::selectRaw('bs_menu.id as id, bs_menu.nama as nama, uri, url, permission, id_role')
                      ->join('bs_menu', 'bs_menu.id', '=', 'bs_menu_permission.id_menu')
                      ->join('bs_role_permission', 'bs_role_permission.id_menu_permission', '=', 'bs_menu_permission.id')
                      ->whereRaw("is_active = 1 AND nama = '$menu' AND id_role = $role")->first();
    if($getmenu){
      $url = '/'.$getmenu['uri'].'/add';
    }
    return $url;
  }

  function formEdit($menu)
  {
    $role = auth()->user()->jabatan->id_role;
    $url = '';
    $getmenu = MenuPermissionModel::selectRaw('bs_menu.id as id, bs_menu.nama as nama, uri, url, permission, id_role')
                      ->join('bs_menu', 'bs_menu.id', '=', 'bs_menu_permission.id_menu')
                      ->join('bs_role_permission', 'bs_role_permission.id_menu_permission', '=', 'bs_menu_permission.id')
                      ->whereRaw("is_active = 1 AND nama = '$menu' AND id_role = $role")->first();
    if($getmenu){
      $url = '/'.$getmenu['uri'].'/edit';
    }
    return $url;
  }

  function formDelete($menu)
  {
    $role = auth()->user()->jabatan->id_role;
    $url = '';
    $getmenu = MenuPermissionModel::selectRaw('bs_menu.id as id, bs_menu.nama as nama, uri, url, permission, id_role')
                      ->join('bs_menu', 'bs_menu.id', '=', 'bs_menu_permission.id_menu')
                      ->join('bs_role_permission', 'bs_role_permission.id_menu_permission', '=', 'bs_menu_permission.id')
                      ->whereRaw("is_active = 1 AND nama = '$menu' AND id_role = $role")->first();
    if($getmenu){
      $url = '/'.$getmenu['uri'].'/delete';
    }
    return $url;
  }

  function formEtc($menu)
  {
    $role = auth()->user()->jabatan->id_role;
    $url = '';
    $getmenu = MenuPermissionModel::selectRaw('bs_menu.id as id, bs_menu.nama as nama, uri, url, permission, id_role')
                      ->join('bs_menu', 'bs_menu.id', '=', 'bs_menu_permission.id_menu')
                      ->join('bs_role_permission', 'bs_role_permission.id_menu_permission', '=', 'bs_menu_permission.id')
                      ->whereRaw("is_active = 1 AND nama = '$menu' AND id_role = $role")->first();
    if($getmenu){
      $url = '/'.$getmenu['uri'];
    }
    return $url;
  }
}
