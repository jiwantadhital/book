<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class college_images extends Model
{
    use HasFactory;
    protected $table='college_images';
    protected $fillable=['image','college_id'];
}
