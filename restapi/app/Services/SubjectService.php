<?php

namespace App\Services;

use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;

class SubjectService{
    protected $subjectRepository;

    public function __construct(SubjectRepository $subjectRepository){
        $this->subjectRepository = $subjectRepository;
    }

    public function getAllSubjects(){
        $subjects = $this->subjectRepository->getAllSubjects();

        if(!$subjects) return null;

        return $subjects;
    }
}
