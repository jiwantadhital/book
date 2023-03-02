<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notes extends Model
{
    use HasFactory;
    protected $table='notes';
    protected $fillable=['notes','sem_id','sub_id','chapter_id'];


    public function Semester()
    {
        return $this->belongsTo(semesters::class, 'sem_id');
    }
    public function Subject()
    {
        return $this->belongsTo(subjects::class, 'sub_id');
    }
    public function Chapter()
    {
        return $this->belongsTo(chapters::class, 'chapter_id');
    }
}
