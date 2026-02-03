<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['name' => 'Matematica I', 'code' => 101, 'uv' => 4],
            ['name' => 'Fisica I', 'code' => 102, 'uv' => 4],
            ['name' => 'Programacion I', 'code' => 201, 'uv' => 4],
            ['name' => 'Base de Datos', 'code' => 202, 'uv' => 4],
            ['name' => 'Estructuras de Datos', 'code' => 203, 'uv' => 4],
            ['name' => 'Redes de Computadoras', 'code' => 301, 'uv' => 3],
            ['name' => 'Sistemas Operativos', 'code' => 302, 'uv' => 4],
            ['name' => 'Ingenieria de Software', 'code' => 303, 'uv' => 4],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
