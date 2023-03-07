<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chapters extends Model
{
    use HasFactory;
    protected $table='chapters';
    protected $fillable=['sem_id','sub_id','name','number'];

    public function Semester()
    {
        return $this->belongsTo(semesters::class, 'sem_id');
    }
    public function Subject()
    {
        return $this->belongsTo(subjects::class, 'sub_id');
    }
}
