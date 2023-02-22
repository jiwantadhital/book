<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class notices extends Model
{
    use HasFactory;
//    use SoftDeletes;
    protected $table ='notices';
    protected $fillable = ['title','short_description','description'];
}

