<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();        
        $this->call(CategoriesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CVitaesTableSeeder::class);   
        $this->call(CommentsTableSeeder::class);   
        $this->call(PublicationsTableSeeder::class);
        $this->call(ApplicationsTableSeeder::class);
        Schema::enableForeignKeyConstraints();
    }
}