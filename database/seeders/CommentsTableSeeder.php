<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Vaciamos la tabla comments
        Comment::truncate();
        $faker = \Faker\Factory::create();
        // Obtenemos todos los artículos de la bdd
        // Obtenemos todos los usuarios
        $users = User::all();
        foreach ($users as $user) {
            // iniciamos sesión con cada uno
            JWTAuth::attempt(['email' => $user->email, 'password' => '123123']);
            // Creamos un comentario para cada artículo con este usuario
            foreach ($user as $users) {
                Comment::create([
                    'content' => $faker->paragraph,
                ]);
            }
        }
    }
}
