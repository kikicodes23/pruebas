<?php

namespace App\Repositories;

use App\Models\Register;

class RegisterRepository {
    public function getAllStudentRegisters($studentId){
        return Register::where('student_id', $studentId)
                        ->with(['subject', 'semester', 'student'])
                        ->get();
    }

    public function createRegister($data){
        return Register::create($data);
    }
}
