<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class semesters extends Model
{
    use HasFactory;
    protected $table='semesters';
    protected $fillable=['name'];
    

    function  subjects(){
        return $this->hasMany(subjects::class);
    }
}
