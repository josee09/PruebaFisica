<?php
// 14-4-23 primer seeder para llamar migración de PrimerUsuario
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        //---------------------------------------------

         //creacion de roles y permisos
         $this->call(RoleSeed::class);
          //usuarios base
          $this->call(PrimerUsuarioSeeder::class);
        $this->call(LugarAsignacionSeeder::class);
    }
}
