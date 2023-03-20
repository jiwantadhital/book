<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    use HasFactory;
    protected $table='comments';
    protected $fillable=['comments_ratting','description','user_id','student_id','college_id'];
    public function User(){
         return $this->belongsto(User::class,'user_id');
    }
    public function Student(){
        return $this->belongsto(students::class,'student_id');
   }
    public function College(){
        return $this->belongsto(colleges::class,'college_id');

    }
}
