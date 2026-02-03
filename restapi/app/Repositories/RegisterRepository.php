<?php

namespace App\Repositories;

use App\Models\Register;

class RegisterRepository{
    public function getAllStudentRegisters($studentId){
        return Register::where('student_id', $studentId)
                        ->with(['subject', 'semester']) //Esta parte nos ayuda a traer la info completa
                        ->get();
    }
}
