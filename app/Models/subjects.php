<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subjects extends Model
{
    use HasFactory;
    protected $table='subjects';
    protected $fillable=['sem_id','title'];

    public function Semester()
    {
        return $this->belongsTo(semesters::class, 'sem_id');
    }
    public function semesters()
    {
        return $this->belongsTo(semesters::class);
    }
}

