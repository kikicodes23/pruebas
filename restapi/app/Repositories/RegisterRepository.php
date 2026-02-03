<?php

namespace App\Repositories;

use App\Models\Register;

class RegisterRepository {
    public function getAllStudentRegisters($studentId){
    return Register::where('student_id', $studentId)
                    ->join('semesters', 'registers.semester_id', '=', 'semesters.id') // Unimos para poder ordenar
                    ->with(['subject', 'semester', 'student'])
                    ->orderBy('semesters.year', 'desc')           // Primero por año descendente
                    ->orderBy('semesters.semester_number', 'desc') // Luego por ciclo descendente
                    ->select('registers.*') // Importante: Seleccionamos solo los datos del registro para evitar conflictos de ID
                    ->get();
}

    public function createRegister($data){
        return Register::create($data);
    }
}
