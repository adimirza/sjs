<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuHeadingModel extends Model
{
    use HasFactory;
    protected $table = 'bs_menu_heading';
    protected $fillable = [
        'nama_heading',
        'created_by',
        'updated_by',
    ];
}
