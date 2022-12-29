<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermissionModel extends Model
{
    use HasFactory;
    protected $table = 'bs_role_permission';
    protected $fillable = [
        'id_menu_permission',
        'id_role',
        'created_by',
        'updated_by',
    ];
}
