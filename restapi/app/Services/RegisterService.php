<?php

namespace App\Services;

use App\Mail\TranscriptMail;
use App\Repositories\RegisterRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class RegisterService{
    protected $registerRepository;

    public function __construct(RegisterRepository $registerRepository){
        $this->registerRepository = $registerRepository;
    }

    public function getAllStudentRegisters($studentId){
        $registers = $this->registerRepository->getAllStudentRegisters($studentId);

        if($registers->isEmpty()) return null;

        return $registers;
    }

    public function createRegister($data){
        return $this->registerRepository->createRegister($data);
    }

    private function preparePdfData($studentId){
        $registers = $this->registerRepository->getAllStudentRegisters($studentId);

        if($registers->isEmpty()) return null;

        $student = $registers->first()->student;

        $pdf = Pdf::loadView('pdf.transcript', compact('registers', 'student'));

        return [
            'pdf' => $pdf,
            'student' => $student
        ];
    }

    public function getTranscriptPdf($studentId)
    {
        $data = $this->preparePdfData($studentId);

        if (!$data) return null;

        return $data['pdf'];
    }

    public function sendTranscriptEmail($studentId)
    {
        $data = $this->preparePdfData($studentId);

        if (!$data) return false; // No hay registros

        try {
            Mail::to($data['student']->email)
                ->send(new TranscriptMail($data['pdf'], $data['student']->name));

            return true; // Éxito
        } catch (\Exception $e) {
            Log::error("Error sending transcript email: " . $e->getMessage());
            return false; // Hubo un error
        }
    }
}
