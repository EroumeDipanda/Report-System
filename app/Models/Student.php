<?php

namespace App\Models;

use App\Models\Mark;
use App\Models\Classe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
