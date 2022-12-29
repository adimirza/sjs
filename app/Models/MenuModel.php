<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    use HasFactory;
    protected $table = 'bs_menu';
    protected $fillable = [
        'parent',
        'nama',
        'url',
        'uri',
        'icon',
        'urutan',
        'status',
        'id_heading',
        'created_by',
        'updated_by',
    ];
}
