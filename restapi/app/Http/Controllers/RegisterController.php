<?php

namespace App\Http\Controllers;

use App\Services\RegisterService;
use Illuminate\Http\Request;
use Validator;

class RegisterController extends Controller{
    protected $registerService;

    public function __construct(RegisterService $registerService){
        $this->registerService = $registerService;
    }

    // Traer todos los registros de un estudiante por su ID
    public function getAllStudentRegisters($studentId){
        $registers = $this->registerService->getAllStudentRegisters($studentId);

        if(is_null($registers)){
            return response()->json([
                'message' => 'No registers found for this student'
            ], 404);
        }

        return response()->json([
            'message' => 'Registers retrieved successfully',
            'data' => $registers
        ], 200);
    }

    // Crear un nuevo registro
    public function storeRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester_id' => 'required|exists:semesters,id',
            'grade' => 'required|numeric|min:0|max:10'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        $register = $this->registerService->createRegister($request->all());

        if(!$register){
            return response()->json([
                'message' => 'Failed to create register'
            ], 500);

        }

        return response()->json([
            'message' => 'Register created successfully',
            'data'=> $register
        ], 200);
    }

    public function downloadTranscript($studentId)
    {
        $pdf = $this->registerService->getTranscriptPdf($studentId);

        if (is_null($pdf)) {
            return response()->json([
                'message' => 'No academic records found for this student.'
            ], 404);
        }

        return $pdf->stream('academic_transcript.pdf');
    }

    public function emailTranscript($studentId){
        $status = $this->registerService->sendTranscriptEmail($studentId);

        if ($status === 'not_found') {
            return response()->json([
                'message' => 'Student not found or has no academic records.'
            ], 404);
        }

        if ($status === 'error') {
            return response()->json([
                'message' => 'Failed to send email due to a server error. Check logs.'
            ], 500);
        }

        // Éxito
        return response()->json([
            'message' => 'Transcript sent successfully to student email.'
        ], 200);
    }
}
