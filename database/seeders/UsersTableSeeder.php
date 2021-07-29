<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Business;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Vaciar la tabla
        User::truncate();
        $faker = \Faker\Factory::create();
        // Crear la misma clave para todos los usuarios
        // conviene hacerlo antes del for para que el seeder
        // no se vuelva lento.
        $password = Hash::make('123123');  
        $admin_password = Hash::make('1721949285Gales');
        $admin=Admin::create(['credential_number'=>'1721949285RivGue']);
        $admin->User()->create([
            'name' => 'Guillermo',
            'last_name'=>'Rivera',                       
            'email' => 'admin@prueba.com',            
            'password' => $admin_password,            
            'province'=>'Pichincha',
            'city'=>'Quito',
            'location'=>'Valle',
            'description' => 'Estudiante de la EPN en Desarrollo de Software',            
            'cellphone' => '0960625886',
            'image' => $faker->imageUrl(400,300, null, false),
            'role'=> User::ROLE_SUPERADMIN,
        ]);
        // Generar algunos usuarios para nuestra aplicacion
        $role=['ROLE_STUDENT','ROLE_BUSINESS'];
        for ($i = 0; $i < 5; $i++) {
            $business=Business::create([
                'ruc'=>'1234567890123',
                'business_name'=>$faker->company,
                'business_type'=>$faker->sentence,
                'business_age'=>$faker->sentence,                                           
            ]);            
            $business->User()->create([
                'name' => $faker->firstName,
                'last_name'=>$faker->lastName,                
                'email' => $faker->email,
                'password' => $password,
                'province'=>'Pichincha',
                'city'=>$faker->sentence, 
                'location'=>$faker->sentence,                            
                'description' => $faker->paragraph,                
                'cellphone' => $faker->phoneNumber,
                'image' => $faker->imageUrl(400,300, null, false),
                'role'=> User::ROLE_BUSINESS,
            ]);    
                   
        };                            
        for ($i = 0; $i < 5; $i++) {
            User::create([
                'name' => $faker->firstName,
                'last_name'=>$faker->lastName, 
                'email' => $faker->email,
                'password' => $password,
                'province'=>$faker->sentence,
                'city'=>$faker->sentence,
                'location'=>$faker->sentence,                
                'description' => $faker->paragraph,                
                'cellphone' => $faker->phoneNumber,
                'image' => $faker->imageUrl(400,300, null, false),
                'role'=> User::ROLE_STUDENT,
            ]);  
        }    
    }
}