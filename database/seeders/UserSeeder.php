<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

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
        'phone'     => '11111111111',
        'email_verified_at' => '10.05.2022'
      ],
      [
        'name'      => 'Vadim Zuev',
        'email'     => 'user@gmail.com',
        'password'  => Hash::make('22222222'),
        'phone'     => '2222222222',
        'email_verified_at' => '10.06.2022'
      ]
    ]);
  }
}
