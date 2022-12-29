<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtributModel extends Model
{
    use HasFactory;
    protected $table = 'atribut';
    protected $fillable = [
        'atribut',
        'status',
        'created_by',
        'updated_by',
    ];
}
