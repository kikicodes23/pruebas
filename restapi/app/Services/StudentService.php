<?php

namespace App\Services;

use App\Repositories\StudentRepository;

class StudentService{
    protected $studentRepository;

    public function __construct(StudentRepository $studentRepository){
        $this->studentRepository = $studentRepository;
    }

    public function getAllStudents($perPage){
        $getAllStudents = $this->studentRepository->getAllStudents($perPage);

        if($getAllStudents->isEmpty()) return null;

        return $getAllStudents;
    }

    public function getStudentById($id){
        $getOneStudent = $this->studentRepository->getStudentById($id);

        if($getOneStudent->isEmpty()) return null;

        return $getOneStudent;
    }

    public function createStudent($data){
        return $this->studentRepository->createStudent($data);
    }

    public function updateStudent($id, $data){
        $student = $this->studentRepository->getStudentById($id);

        // Si no existe, lanzamos una excepción (no un string)
        if (!$student) {
            throw new \Exception("StudentNotFound");
        }

        return $this->studentRepository->updateStudent($id, $data);
    }

    public function deleteStudent($id){
        $student = $this->studentRepository->getStudentById($id);

        if (!$student) {
            throw new \Exception("StudentNotFound");
        }

        return $this->studentRepository->deleteStudent($id);
    }

    public function searchStudents($term, $perPage) {
        // Limpiamos espacios en blanco
        $term = trim($term);

        if (empty($term)) {
            throw new \Exception("EmptySearchTerm");
        }

        $students = $this->studentRepository->filterStudents($term, $perPage);

        if ($students->isEmpty()) {
            throw new \Exception("NoResultsFound");
        }

        return $students;
    }
}
