<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

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
        for ($i = 0; $i < 7; $i++) {
            Category::create([
                'designation' => $faker->randomElement($designation),
            ]);
        }
    }
}
