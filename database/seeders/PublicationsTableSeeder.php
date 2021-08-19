<?php

namespace Database\Seeders;

use App\Models\Publication;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Tymon\JWTAuth\Facades\JWTAuth;

class PublicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Vaciar la tabla articles.
        Publication::truncate();
        $faker = \Faker\Factory::create();
        // Obtenemos la lista de todos los usuarios creados e
        // iteramos sobre cada uno y simulamos un inicio de
        // sesión con cada uno para crear artículos en su nombre
        $publication = Publication::all();
        $users = User::all();
        foreach ($users as $user) {
            // iniciamos sesión con este usuario
            JWTAuth::attempt(['email' => $user->email, 'password' => '123123']);
            // Y ahora con este usuario creamos algunos articulos
            $num_publications = 5;
            for ($j = 0; $j < $num_publications; $j++) {
                Publication::create([
                    'career' => $faker->sentence,
                    'description' => $faker->paragraph,
                    'hours' => $faker->sentence,
                    'date' => $faker->date,
                    'user_id'=>$user->id,
                    'category_id' => $faker->numberBetween(1, 7),
                ]);
            }
        }
    }
}