<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SemesterController extends Controller
{
    protected $semesterService;

    public function __construct(\App\Services\SemesterService $semesterService)
    {
        $this->semesterService = $semesterService;
    }

    public function index()
    {
        $semesters = $this->semesterService->getAllSemesters();

        if ($semesters->isEmpty()) {
            return response()->json([
                'message' => 'No semesters found'
            ], 404);
        }

        return response()->json([
            'message' => 'Semesters retrieved successfully',
            'data' => $semesters
        ], 200);
    }
}
