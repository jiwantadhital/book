<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class students extends Model
{
    use HasFactory;
    protected $table='students';
    protected $fillable=['name','user_id','phone','image','sem_id','college_id','otp'];
    public function Semester()
    {
        return $this->belongsTo(semesters::class, 'sem_id');
    }
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function College()
    {
        return $this->belongsTo(chapters::class, 'college_id');
    }
}
