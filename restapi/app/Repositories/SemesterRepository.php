<?php

namespace App\Repositories;

use App\Models\Semester;

class SemesterRepository{

    public function getAllSemesters(){
        return Semester::all();
    }
}
