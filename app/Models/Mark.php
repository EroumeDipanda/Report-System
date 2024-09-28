<?php

namespace App\Models;

use App\Models\Classe;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mark extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe_id'); // Adjust 'classe_id' if it's different
    }
}
