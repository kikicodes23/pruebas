<?php

namespace App\Services;

use App\Repositories\RegisterRepository;

class RegisterService{
    protected $registerRepository;

    public function __contructor(RegisterRepository $registerRepository){
        $this->registerRepository = $registerRepository;
    }

    public function getAllStudentRegisters($studentId){
        $registers = $this->registerRepository->getAllStudentRegisters($studentId);

        if($registers->isEmpty()) return null;

        return $registers;
    }
}
