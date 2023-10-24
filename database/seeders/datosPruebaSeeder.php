<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class datosPruebaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newUser = new User;
        $newUser->nombre = "testAdmin";
        $newUser->correo="correoAdminTest@gmail.com";
        $newUser->telefono=123456;
        $newUser->password= "$2y$10$5hAuuPXPKqEmlM49g08sWOxqoij8A52TNr1oWJ.VafdP5SmoAMHIC"; //1234
        $newUser->rol= strtoupper("admin");
        $newUser->save();

        $newUser = new User;
        $newUser->nombre = "testAlumno";
        $newUser->correo="correoAlumnoTest@gmail.com";
        $newUser->telefono=123456;
        $newUser->password= "$2y$10$5hAuuPXPKqEmlM49g08sWOxqoij8A52TNr1oWJ.VafdP5SmoAMHIC"; //1234
        $newUser->rol= strtoupper("Alumno");
        $newUser->save();
    }
}
