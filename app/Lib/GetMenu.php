<?php

namespace App\Lib;

use App\Models\JabatanModel;
use App\Models\MenuHeadingModel;
use App\Models\MenuModel;
use App\Models\MenuPermissionModel;

class GetMenu
{

  function getAllMenus($title)
  {
    $heading = MenuHeadingModel::orderBy('id')->get();
    $html_out = '<ul class="sidebar-nav" id="sidebar-nav">';
    $html_out .= $this->getMenus(0, $title);
    foreach($heading as $head){
      if($this->getMenus($head['id'], $title)){
        $html_out .= '<li class="nav-heading">'.$head['nama_heading'].'</li>';
        $html_out .= $this->getMenus($head['id'], $title);
      }
      // $html_out .= '<li class="nav-heading">'.$head['nama_heading'].'</li>';
    }
    $html_out .= '</ul>';
    return $html_out;
  }

  function getMenus($heading, $title=null)
  {
    $role = auth()->user()->jabatan->id_role;
    $parent = MenuModel::where('nama', $title)->first();
    $menus = MenuPermissionModel::selectRaw('bs_menu.id as id, parent, bs_menu.nama as nama, uri, url, icon, id_role')
                      ->join('bs_menu', 'bs_menu.id', '=', 'bs_menu_permission.id_menu')
                      ->join('bs_role_permission', 'bs_role_permission.id_menu_permission', '=', 'bs_menu_permission.id')
                      ->whereRaw("bs_menu.status = 1 AND bs_menu.parent IS NULL AND id_role = $role AND permission = 'read' AND id_heading = $heading")->get();
    $status = '';
    $open = 'collapsed';
    $url = url('/');
    $html_out = '';
    foreach($menus as $menu){
      if($title == $menu['nama']){
        $status = 'active';
      }

      if($parent){
        if($parent['parent']){
          if($parent['parent'] == $menu['id']){
            $open = '';
          }
        }
      }
      
      $url = url('/'.$menu['uri']);
      $child = $this->getChilds($menu['id'], $title);
      if(!$child){
        $html_out .= '<li class="nav-item ">
                        <a href="'.$url.'" class="nav-link '.$status.'">
                            <i class="'.$menu['icon'].'"></i>
                            <span>
                                '.$menu['nama'].'
                            </span>
                        </a>
                      </li>';
      }else{
        $html_out .= '<li class="nav-item ">
                          <a class="nav-link '.$open.'" data-bs-target="#menu'.$menu['id'].'-nav" data-bs-toggle="collapse" href="#">
                              <i class="'.$menu['icon'].'"></i><span>'.$menu['nama'].'</span><i class="'.$menu['icon'].'"></i>
                          </a>';
        $html_out .= '<ul id="menu'.$menu['id'].'-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">';
        $html_out .= $child;
        $html_out .= '</ul>';
        $html_out .= '</li>';
      }
      $status = '';
      $open = '';
    }
    return $html_out;
  }

  function getChilds($parent, $title)
  {
    $role = auth()->user()->jabatan->id_role;
    $menus_child = MenuPermissionModel::selectRaw('bs_menu.id as id, nama, uri, url, icon, id_role')
                      ->join('bs_menu', 'bs_menu.id', '=', 'bs_menu_permission.id_menu')
                      ->join('bs_role_permission', 'bs_role_permission.id_menu_permission', '=', 'bs_menu_permission.id')
                      ->whereRaw("bs_menu.status = 1 AND bs_menu.parent = $parent AND id_role = $role AND permission = 'read'")->get();
    $status = '';
    $url = url('/');
    $html_out = '';
    foreach($menus_child as $child){
      if($title == $child['nama']){
        $status = 'active';
      }
      $url = url('/'.$child['uri']);
      $html_out .= '<li>
                      <a href="'.$url.'">
                          <i class="bi bi-circle '.$status.'"></i><span>'.$child['nama'].'</span>
                      </a>
                    </li>';
      $status = '';
    }
    return $html_out;
  }
}
