<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPermissionModel extends Model
{
    use HasFactory;
    protected $table = 'bs_menu_permission';
    protected $fillable = [
        'id_menu',
        'permission',
        'is_active',
        'created_by',
        'updated_by',
    ];

    const PERMISSION = [
        'create',
        'read',
        'update',
        'delete',
        'import',
        'export'
    ];
}
