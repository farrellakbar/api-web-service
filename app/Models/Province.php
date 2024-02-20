<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    Protected $table = 'indonesia_provinces';
    protected $fillable = ['code', 'name', 'meta'];
}
