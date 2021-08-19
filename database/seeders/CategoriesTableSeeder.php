<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Vaciamos la tabla categories
        Category::truncate();
        $faker = \Faker\Factory::create();
        $designation = ['Ingeniería', 'Ciencias', 'Tecnología Superior', 'Enfermería', 'Medicina', 'Leyes', 'Idiomas'];
        $users = User::all();
        for ($i = 0; $i < 7; $i++) {
            Category::create([
                'designation' => $faker->randomElement($designation),
                'user_id' => $user->id,
            ]);
        }
    }
}