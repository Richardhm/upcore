<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            //PlanosTableSeeder::class,
            PermissionsTableSeeder::class,
            AcomodacaoTableSeeder::class,
            //ColetivosTableSeeder::class,
            FaixasEtariasTableSeeder::class,
            PlanosTableSeeder::class,
            EtiquetasTableSeeder::class,
            FinanceirosTableSeeder::class
        ]);
    }
}
