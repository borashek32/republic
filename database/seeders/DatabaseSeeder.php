<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(ModelHasRolesSeeder::class);

        \App\Models\User::factory(10)->create();
        \App\Models\Tree::factory(3)->create();
        \App\Models\Grass::factory(3)->create();
        \App\Models\Flower::factory(3)->create();
        \App\Models\Post::factory(100)->create();
    }
}
