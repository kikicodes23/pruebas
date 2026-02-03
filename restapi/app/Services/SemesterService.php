<?php

namespace App\Services;

use App\Models\Semester;
use App\Repositories\SemesterRepository;

class SemesterService{
    protected $semesterRepository;

    public function __construct(SemesterRepository $semesterRepository){
        $this->semesterRepository = $semesterRepository;
    }

    public function getAllSemesters(){
        $semesters = $this->semesterRepository->getAllSemesters();

        if(!$semesters) return null;

        return $semesters;
    }
}
