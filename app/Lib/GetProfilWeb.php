<?php

namespace App\Lib;

use App\Models\ProfilWebModel;

class GetProfilWeb
{
  function getProfil()
  {
    $field_profil = new ProfilWebModel();
    $result = $field_profil->getFillable();
    foreach($result as $res){
      $value = ProfilWebModel::select($res)->first();
      $result[$res] = $value;
    }
    return $result;
  }
}
