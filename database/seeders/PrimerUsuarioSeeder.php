<?php
// 14-4-23 primer seeder para migración
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PrimerUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contraseña = "9@EgH$7m!LwN1";
        User::create([
            "name" => "ADMINISTRADOR",
            "firstname" => "ADMINISTRADOR",
            "lastname" => "ADMINISTRADOR",
            "grado" => "Auxiliar",
            "assignment" => "TELEMATICA",
            "address" => "TELEMATICA",
            "udep" => "DPT",
            "department" => "DESAROLLO",
            "email" => "admin@gmail.com",
            //encriptación de password
            "password" => Hash::make($contraseña),
        ])->assignRole('Administrador');




        // $contraseña = " M3d1c0$S3gur0!";
        // User::create([
        //     "name" => "MEDICO",
        //     "firstname"=>"JOSUE",
        //     "lastname" => "ALVARADO",
        //     "grado"=>"Auxiliar",
        //     "assignment"=>"TELEMATICA",
        //     "address"=>"TELEMATICA",
        //     "udep"=> "DPT",
        //     "department"=>"DESAROLLO",
        //     "email" => "medico@gmail.com",
        //     //encriptación de password
        //     "password" => Hash::make($contraseña),
        // ])->assignRole('Medico');


        $contraseña = "SegEvalu@dor2023";
        User::create([
            "name" => "EVALUADOR",
            "firstname" => "CLAUDIA",
            "lastname" => "SANCHEZ",
            "grado" => "Auxiliar",
            "assignment" => "TELEMATICA",
            "address" => "TELEMATICA",
            "udep" => "DPT",
            "department" => "DESAROLLO",
            "email" => "evaluador@gmail.com",
            //encriptación de password
            "password" => Hash::make($contraseña),
        ])->assignRole('Evaluador');
    }



}
