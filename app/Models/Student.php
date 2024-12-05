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

    public function getMarkForSubject($subjectId, $sequence)
    {
        // Find all mark records for the given subject_id
        $markRecord = $this->marks->where('subject_id', $subjectId)->where('sequence', $sequence)->first();

        // Check if the mark record is found for the given subject and sequence
        if ($markRecord) {
            return $markRecord->mark ?? 0;  // Return the mark, default to 0 if it's not set
        }

        // If no mark record is found, return 0 or another default value
        return 0;  
    }

}
