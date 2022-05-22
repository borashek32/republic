<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
  DB::table('users')->insert([
      [
        'name'      => 'Nataly Zueva',
        'email'     => 'admin@gmail.com',
        'password'  => Hash::make('11111111'),
        'email_verified_at' => '10.05.2022',
        'remember_token' => Str::random(10),
      ],
      [
        'name'      => 'Vadim Zuev',
        'email'     => 'user@gmail.com',
        'password'  => Hash::make('22222222'),
        'email_verified_at' => '10.06.2022',
        'remember_token' => Str::random(10),
      ]
    ]);
  }
}
