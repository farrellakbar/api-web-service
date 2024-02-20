<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    Protected $table = 'indonesia_cities';
    protected $fillable = ['code', 'province_code', 'name', 'meta'];

}
