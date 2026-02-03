<?php

namespace App\Repositories;

use App\Models\Student;

class StudentRepository{

    public function getAllStudents($perPage){
        return Student::paginate($perPage);
    }

    public function getStudentById($id){
        return Student::find($id);
    }

    public function createStudent($data){
        return Student::create($data);
    }

    public function updateStudent($id,$data){
        $student = $this->getStudentById($id);

        $student->fill($data);
        return $student;
    }

    public function deleteStudent($id){
        $student = $this->getStudentById($id);
        return $student->delete();
    }
}
