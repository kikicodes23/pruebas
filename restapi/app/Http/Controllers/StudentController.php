<?php

namespace App\Http\Controllers;

use App\Services\StudentService;
use Illuminate\Http\Request;
use Validator;

class StudentController extends Controller{
    protected $studentService;

    public function __construct(StudentService $studentService)
{
        $this->studentService = $studentService;
    }

    //Traer todos los estudiantes
    public function index(Request $request){
        $perPage = $request->query('per_page', 10);

        if (!is_numeric($perPage) || $perPage <= 0) {
            $perPage = 10;
        }

        $students = $this->studentService->getAllStudents($perPage);

        if (is_null($students)) {
            return response()->json([
                'message' => 'No students found'
                ], 404);
        }

        return response()->json([
            'message' => 'Students retrieved successfully',
            'data' => $students
        ], 200);
    }

    // Traer un estudiante por ID
    public function getOneStudent($id){
        $student = $this->studentService->getStudentById($id);

        if (is_null($student)) {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Student retrieved successfully',
            'data' => $student
        ], 200);
    }

    // Crear un nuevo estudiante
    public function storeStudent(Request $request){
        $validator = Validator::make($request->all(), [
            'carnet' => 'required|unique:students|integer',
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:students,email',
            'career' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        $student = $this->studentService->createStudent($request->all());

        if (!$student) {
            return response()->json([
                'message' => 'Student creation failed'
            ], 500);
        }

        return response()->json([
            'message' => 'Student created successfully',
            'data' => $student
        ], 200);
    }

    // Actualizar un estudiante existente
    public function updateStudent(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'carnet' => 'sometimes|unique:students|integer',
            'name' => 'sometimes',
            'lastname' => 'sometimes',
            'email' => 'sometimes|email|unique:students,email',
            'career' => 'sometimes',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $updatedStudent = $this->studentService->updateStudent($id, $request->all());

            return response()->json([
                'message' => 'Student updated successfully',
                'data' => $updatedStudent
            ], 200);

        } catch (\Exception $e) {
            // Traducimos la excepción del Service a un error HTTP
            if ($e->getMessage() === "StudentNotFound") {
                return response()->json(['error' => 'The student requested does not exist'], 404);
            }

            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    // Eliminar un estudiante
    public function destroyStudent(Request $request, $id){
        try {
            $this->studentService->deleteStudent($id);

            return response()->json([
                'message' => 'Student deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            // Traducimos la excepción del Service a un error HTTP
            if ($e->getMessage() === "StudentNotFound") {
                return response()->json(['error' => 'The student requested does not exist'], 404);
            }

            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
