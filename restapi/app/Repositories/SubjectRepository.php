<?php

namespace App\Repositories;

use App\Models\Subject;

class SubjectRepository{
    public function getAllSubjects(){
        return Subject::all();
    }
}
