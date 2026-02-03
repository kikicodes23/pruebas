<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semesters = [
            ['year' => 2023, 'semester_number' => 1],
            ['year' => 2023, 'semester_number' => 2],
            ['year' => 2024, 'semester_number' => 1],
            ['year' => 2024, 'semester_number' => 2],
            ['year' => 2025, 'semester_number' => 1],
            ['year' => 2025, 'semester_number' => 2],
        ];

        foreach ($semesters as $semester) {
            Semester::create($semester);
        }
    }
}
