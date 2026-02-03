<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'carnet' => 'A0001',
                'name' => 'Ana',
                'lastname' => 'Lopez',
                'email' => 'ana.lopez@example.com',
                'career' => 'Ingenieria en Sistemas',
            ],
            [
                'carnet' => 'A0002',
                'name' => 'Carlos',
                'lastname' => 'Martinez',
                'email' => 'carlos.martinez@example.com',
                'career' => 'Ingenieria en Sistemas',
            ],
            [
                'carnet' => 'A0003',
                'name' => 'Diana',
                'lastname' => 'Hernandez',
                'email' => 'diana.hernandez@example.com',
                'career' => 'Ingenieria Industrial',
            ],
            [
                'carnet' => 'A0004',
                'name' => 'Ernesto',
                'lastname' => 'Garcia',
                'email' => 'ernesto.garcia@example.com',
                'career' => 'Ingenieria en Sistemas',
            ],
            [
                'carnet' => 'A0005',
                'name' => 'Fernanda',
                'lastname' => 'Castro',
                'email' => 'fernanda.castro@example.com',
                'career' => 'Ingenieria Civil',
            ],
            [
                'carnet' => 'A0006',
                'name' => 'Gabriel',
                'lastname' => 'Mendoza',
                'email' => 'gabriel.mendoza@example.com',
                'career' => 'Ingenieria en Sistemas',
            ],
            [
                'carnet' => 'A0007',
                'name' => 'Helena',
                'lastname' => 'Vargas',
                'email' => 'helena.vargas@example.com',
                'career' => 'Ingenieria Industrial',
            ],
            [
                'carnet' => 'A0008',
                'name' => 'Ivan',
                'lastname' => 'Reyes',
                'email' => 'ivan.reyes@example.com',
                'career' => 'Ingenieria Civil',
            ],
            [
                'carnet' => 'A0009',
                'name' => 'Julia',
                'lastname' => 'Sanchez',
                'email' => 'julia.sanchez@example.com',
                'career' => 'Ingenieria en Sistemas',
            ],
            [
                'carnet' => 'A0010',
                'name' => 'Kevin',
                'lastname' => 'Ortega',
                'email' => 'kevin.ortega@example.com',
                'career' => 'Ingenieria en Sistemas',
            ],
            [
                'carnet' => 'A0011',
                'name' => 'Laura',
                'lastname' => 'Ruiz',
                'email' => 'laura.ruiz@example.com',
                'career' => 'Ingenieria Industrial',
            ],
            [
                'carnet' => 'A0012',
                'name' => 'Mario',
                'lastname' => 'Alvarez',
                'email' => 'mario.alvarez@example.com',
                'career' => 'Ingenieria Civil',
            ],
            [
                'carnet' => 'A0013',
                'name' => 'Natalia',
                'lastname' => 'Mora',
                'email' => 'natalia.mora@example.com',
                'career' => 'Ingenieria en Sistemas',
            ],
            [
                'carnet' => 'A0014',
                'name' => 'Oscar',
                'lastname' => 'Cruz',
                'email' => 'oscar.cruz@example.com',
                'career' => 'Ingenieria Industrial',
            ],
            [
                'carnet' => 'A0015',
                'name' => 'Paula',
                'lastname' => 'Flores',
                'email' => 'paula.flores@example.com',
                'career' => 'Ingenieria en Sistemas',
            ],
            [
                'carnet' => 'A0016',
                'name' => 'Ricardo',
                'lastname' => 'Chavez',
                'email' => 'ricardo.chavez@example.com',
                'career' => 'Ingenieria Civil',
            ],
            [
                'carnet' => 'A0017',
                'name' => 'Sofia',
                'lastname' => 'Nunez',
                'email' => 'sofia.nunez@example.com',
                'career' => 'Ingenieria en Sistemas',
            ],
            [
                'carnet' => 'A0018',
                'name' => 'Tomas',
                'lastname' => 'Pineda',
                'email' => 'tomas.pineda@example.com',
                'career' => 'Ingenieria Industrial',
            ],
            [
                'carnet' => 'A0019',
                'name' => 'Valeria',
                'lastname' => 'Campos',
                'email' => 'valeria.campos@example.com',
                'career' => 'Ingenieria Civil',
            ],
            [
                'carnet' => 'A0020',
                'name' => 'William',
                'lastname' => 'Acosta',
                'email' => 'william.acosta@example.com',
                'career' => 'Ingenieria en Sistemas',
            ],
            [
                'carnet' => 'A0021',
                'name' => 'Ximena',
                'lastname' => 'Aguilar',
                'email' => 'ximena.aguilar@example.com',
                'career' => 'Ingenieria Industrial',
            ],
            [
                'carnet' => 'A0022',
                'name' => 'Yahir',
                'lastname' => 'Ramos',
                'email' => 'yahir.ramos@example.com',
                'career' => 'Ingenieria en Sistemas',
            ],
            [
                'carnet' => 'A0023',
                'name' => 'Zoe',
                'lastname' => 'Iglesias',
                'email' => 'zoe.iglesias@example.com',
                'career' => 'Ingenieria Civil',
            ],
            [
                'carnet' => 'A0024',
                'name' => 'Andres',
                'lastname' => 'Peña',
                'email' => 'andres.pena@example.com',
                'career' => 'Ingenieria en Sistemas',
            ],
            [
                'carnet' => 'A0025',
                'name' => 'Beatriz',
                'lastname' => 'Salinas',
                'email' => 'beatriz.salinas@example.com',
                'career' => 'Ingenieria Industrial',
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
