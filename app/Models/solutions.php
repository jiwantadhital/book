<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solutions extends Model
{
    use HasFactory;
    protected $table='solutions';
    protected $fillable=['sem_id','sub_id','questionyear_id','image'];

    public function Semester()
    {
        return $this->belongsTo(semesters::class, 'sem_id');
    }
    public function Subject()
    {
        return $this->belongsTo(subjects::class, 'sub_id');
    }
    public function Qyear()
    {
        return $this->belongsTo(questionyears::class, 'questionyear_id');
    }
}
