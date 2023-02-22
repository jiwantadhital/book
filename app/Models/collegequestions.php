<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class collegequestions extends Model
{
    use HasFactory;
    protected $table='collegequestions';
    protected $fillable=['sem_id','sub_id','collegeyear_id','image'];

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
        return $this->belongsTo(collegeyears::class, 'collegeyear_id');
    }
}
