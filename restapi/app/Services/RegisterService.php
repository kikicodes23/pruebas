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

    public function generateTranscript($studentId)
    {
        // 1. Fetch data
        $registers = $this->registerRepository->getAllStudentRegisters($studentId);

        if($registers->isEmpty()) return null;

        // 2. Extract student info from the first record
        $student = $registers->first()->student;

        // 3. Generate PDF (Load view)
        $pdf = Pdf::loadView('pdf.transcript', compact('registers', 'student'));

        // 4. Send Email (Wrapped in try/catch to avoid breaking the download if SMTP fails)
        try {
            Mail::to($student->email)->send(new TranscriptMail($pdf, $student->name));
        } catch (\Exception $e) {
            Log::error("Error sending transcript email: " . $e->getMessage());
        }

        // 5. Return PDF object
        return $pdf;
    }
}
