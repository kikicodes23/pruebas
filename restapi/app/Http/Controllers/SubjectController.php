<?php

namespace App\Http\Controllers;

use App\Services\SubjectService;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $subjectService;

    public function __construct(SubjectService $subjectService){
        $this->subjectService = $subjectService;
    }

    public function index(){
        $subjects = $this->subjectService->getAllSubjects();

        if($subjects->isEmpty()){
            return response()->json([
                'message' => 'No subjects found'
            ], 404);
        }

        return response()->json([
            'message' => 'Subjects retrieved successfully',
            'data' => $subjects
        ], 200);
    }
}
