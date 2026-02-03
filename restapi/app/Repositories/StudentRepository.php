<?php

namespace App\Repositories;

use App\Models\Student;

class StudentRepository{

    public function getAllStudents($perPage, $term){
        if(!$term)
            return Student::paginate($perPage);

        return Student::where(function ($query) use ($term) {
        $query->where('name', 'LIKE', "%{$term}%")
                ->orWhere('lastname', 'LIKE', "%{$term}%")
                ->orWhere('carnet', 'LIKE', "%{$term}%");
        })->paginate($perPage);
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
