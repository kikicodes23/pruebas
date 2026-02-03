<?php

namespace App\Services;

use App\Repositories\StudentRepository;

class StudentService{
    protected $studentRepository;

    public function __construct(StudentRepository $studentRepository){
        $this->studentRepository = $studentRepository;
    }

    public function getAllStudents($perPage, $term){
        // Si hay término de búsqueda, validar que no esté vacío
        if ($term) {
            $term = trim($term);

            if (empty($term)) {
                throw new \Exception("EmptySearchTerm");
            }
        }

        $termLower = strtolower($term);

        // El repositorio maneja tanto búsqueda como listado completo
        return $this->studentRepository->getAllStudents($perPage, $termLower);
    }

    public function getStudentById($id){
        $getOneStudent = $this->studentRepository->getStudentById($id);

        if(!$getOneStudent) return null;

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
}
