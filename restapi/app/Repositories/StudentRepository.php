<?php

namespace App\Repositories;

use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentRepository{

    public function getAllStudents($perPage, $term){
        if (is_null($term) || empty($term)) {
            return Student::orderBy('name', 'asc')
                            ->paginate($perPage);
        }

        return Student::where(function ($query) use ($term) {
            $query->whereRaw('LOWER(name) LIKE ?', ["%{$term}%"])
                    ->orWhereRaw('LOWER(lastname) LIKE ?', ["%{$term}%"])
                    ->orWhere('carnet', 'LIKE', "%{$term}%");
        })
        ->orderBy('name', 'asc')
        ->paginate($perPage);
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
        $student->save();
        return $student;
    }

    public function deleteStudent($id){
        $student = $this->getStudentById($id);
        return $student->delete();
    }
}
