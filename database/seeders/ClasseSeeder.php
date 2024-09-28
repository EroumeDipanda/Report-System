<?php

namespace Database\Seeders;

use App\Models\Classe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('classes')->insert([
            [
                'name' => 'FORM 1',
                'code_classe' => 'F1',
            ],
            [
                'name' => 'FORM 2',
                'code_classe' => 'F2',
            ],
            [
                'name' => 'FORM 3',
                'code_classe' => 'F3',
            ],
            [
                'name' => '6eme',
                'code_classe' => '6e',
            ],
            [
                'name' => '5eme',
                'code_classe' => '5e',
            ],
            [
                'name' => '4eme',
                'code_classe' => '4e',
            ],
        ]);
    }

}
