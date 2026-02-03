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
}
