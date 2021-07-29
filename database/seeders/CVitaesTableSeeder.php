<?php

namespace Database\Seeders;

use App\Models\CVitae;
use App\Models\User;
use Illuminate\Database\Seeder;
use Tymon\JWTAuth\Facades\JWTAuth;

class CVitaesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Vaciamos la tabla comments
        CVitae::truncate();
        $faker = \Faker\Factory::create();
        // Obtenemos todos los artículos de la bdd
        // Obtenemos todos los usuarios
        $users = User::all();
        $languages=[
            'Inglés',
            'Alemán',
            'Chino',
            'Japonés',
            'Ruso',
            'Italiano',
            'Kichwa',
            'Coreano',
        ];
        $level_languages=['Medio','Avanzado','Experto'];
        foreach ($users as $user) {
            // iniciamos sesión con cada uno
            JWTAuth::attempt(['email' => $user->email, 'password' => '123123']);
            // Creamos un comentario para cada artículo con este usuario
            for ($i = 0; $i < 1 ; $i++) {
                CVitae::create([
                    'university' => $faker->company,
                    'career'=>$faker->sentence,
                    'language'=>$faker->randomElement($languages),
                    'level_language'=>$faker->randomElement($level_languages),
                    'habilities'=>$faker->paragraph,
                    'certificates'=>$faker->paragraph,
                    'highschool_degree'=>$faker->sentence,
                    'work_experience'=>$faker->paragraph,
                ]);
            }
        }
    }
}