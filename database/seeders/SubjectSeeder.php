<?php

namespace Database\Seeders;

use App\Models\Classe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Fetch all class IDs
        $classes = Classe::all();

        // Define subjects to be added with teachers
        $subjects = [
            ['name' => 'MATHEMATICS', 'code_subject' => 'MAT', 'coef' => 4, 'teacher' => 'Mr. Smith'],
            ['name' => 'ENGLISH', 'code_subject' => 'ENG', 'coef' => 4, 'teacher' => 'Ms. Johnson'],
            ['name' => 'FRENCH', 'code_subject' => 'FRE', 'coef' => 4, 'teacher' => 'Mme. Dubois'],
            ['name' => 'GEOGRAPHY', 'code_subject' => 'GEO', 'coef' => 2, 'teacher' => 'Mr. Brown'],
            ['name' => 'ECONOMICS', 'code_subject' => 'ECO', 'coef' => 2, 'teacher' => 'Ms. Green'],
            ['name' => 'HISTORY', 'code_subject' => 'HIS', 'coef' => 2, 'teacher' => 'Mr. White'],
            ['name' => 'CHEMISTRY', 'code_subject' => 'CHE', 'coef' => 2, 'teacher' => 'Dr. Black'],
            ['name' => 'PHYSICS', 'code_subject' => 'PHY', 'coef' => 2, 'teacher' => 'Dr. Blue'],
            ['name' => 'BIOLOGY', 'code_subject' => 'BIO', 'coef' => 2, 'teacher' => 'Ms. Yellow'],
            ['name' => 'COMPUTER', 'code_subject' => 'COM', 'coef' => 2, 'teacher' => 'Mr. Gray'],
            ['name' => 'CITIZENSHIP', 'code_subject' => 'CIT', 'coef' => 2, 'teacher' => 'Ms. White'],
            ['name' => 'MANUAL LABOUR', 'code_subject' => 'M.L', 'coef' => 1, 'teacher' => 'Mr. Green'],
            ['name' => 'PHYSICAL EDUCATION', 'code_subject' => 'P.E', 'coef' => 2, 'teacher' => 'Ms. Blue'],
        ];

        // Insert subjects for each class
        foreach ($classes as $class) {
            foreach ($subjects as $subject) {
                DB::table('subjects')->insert([
                    'name' => $subject['name'],
                    'code_subject' => $subject['code_subject'],
                    'classe_id' => $class->id,
                    'coef' => $subject['coef'],
                    'teacher' => $subject['teacher'], // Include the teacher's name
                ]);
            }
        }
    }

}
