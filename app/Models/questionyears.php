<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class questionyears extends Model
{
    use HasFactory;
    protected $table='questionyears';
    protected $fillable=['name'];
}
