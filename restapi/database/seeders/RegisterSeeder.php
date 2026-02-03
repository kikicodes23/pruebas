<?php

namespace Database\Seeders;

use App\Models\Register;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class RegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semester2023_1 = Semester::where('year', 2023)->where('semester_number', 1)->firstOrFail();
        $semester2023_2 = Semester::where('year', 2023)->where('semester_number', 2)->firstOrFail();
        $semester2024_1 = Semester::where('year', 2024)->where('semester_number', 1)->firstOrFail();
        $semester2024_2 = Semester::where('year', 2024)->where('semester_number', 2)->firstOrFail();
        $semester2025_1 = Semester::where('year', 2025)->where('semester_number', 1)->firstOrFail();
        $semester2025_2 = Semester::where('year', 2025)->where('semester_number', 2)->firstOrFail();

        $students = [
            1 => Student::findOrFail(1),
            'A0001' => Student::where('carnet', 'A0001')->firstOrFail(),
            'A0002' => Student::where('carnet', 'A0002')->firstOrFail(),
            'A0003' => Student::where('carnet', 'A0003')->firstOrFail(),
            'A0004' => Student::where('carnet', 'A0004')->firstOrFail(),
            'A0005' => Student::where('carnet', 'A0005')->firstOrFail(),
        ];

        $subjects = [
            101 => Subject::where('code', 101)->firstOrFail(),
            102 => Subject::where('code', 102)->firstOrFail(),
            201 => Subject::where('code', 201)->firstOrFail(),
            202 => Subject::where('code', 202)->firstOrFail(),
            203 => Subject::where('code', 203)->firstOrFail(),
            301 => Subject::where('code', 301)->firstOrFail(),
            302 => Subject::where('code', 302)->firstOrFail(),
            303 => Subject::where('code', 303)->firstOrFail(),
        ];

        $registers = [
            ['student' => 1, 'subject' => 101, 'semester' => $semester2023_1->id, 'grade' => 8.5],
            ['student' => 1, 'subject' => 102, 'semester' => $semester2023_1->id, 'grade' => 7.9],
            ['student' => 1, 'subject' => 201, 'semester' => $semester2023_2->id, 'grade' => 9.0],
            ['student' => 1, 'subject' => 202, 'semester' => $semester2023_2->id, 'grade' => 8.2],
            ['student' => 1, 'subject' => 203, 'semester' => $semester2024_1->id, 'grade' => 8.8],
            ['student' => 1, 'subject' => 301, 'semester' => $semester2024_1->id, 'grade' => 7.6],
            ['student' => 1, 'subject' => 302, 'semester' => $semester2024_2->id, 'grade' => 9.1],
            ['student' => 1, 'subject' => 303, 'semester' => $semester2024_2->id, 'grade' => 8.4],
            ['student' => 1, 'subject' => 101, 'semester' => $semester2025_1->id, 'grade' => 8.9],
            ['student' => 1, 'subject' => 201, 'semester' => $semester2025_2->id, 'grade' => 9.3],
            ['student' => 'A0002', 'subject' => 102, 'semester' => $semester2024_1->id, 'grade' => 7.8],
            ['student' => 'A0002', 'subject' => 202, 'semester' => $semester2024_2->id, 'grade' => 8.9],
            ['student' => 'A0003', 'subject' => 203, 'semester' => $semester2024_2->id, 'grade' => 7.5],
            ['student' => 'A0004', 'subject' => 301, 'semester' => $semester2024_2->id, 'grade' => 8.0],
            ['student' => 'A0005', 'subject' => 302, 'semester' => $semester2024_2->id, 'grade' => 9.3],
            ['student' => 'A0005', 'subject' => 303, 'semester' => $semester2024_2->id, 'grade' => 8.7],
        ];

        foreach ($registers as $register) {
            Register::create([
                'student_id' => $students[$register['student']]->id,
                'subject_id' => $subjects[$register['subject']]->id,
                'semester_id' => $register['semester'],
                'grade' => $register['grade'],
            ]);
        }
    }
}
