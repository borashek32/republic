<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterNewUsers extends DuskTestCase
{
    public function testUserCanRegister()
    {
        $faker     = Faker::create();
        $password  = $faker->password;

        $this->browse(function (Browser $browser) use($faker, $password) {
            $browser->visit('/register')
                ->pause(1000)
                ->type('name', $faker->firstName)
                ->type('email', $faker->email)
                ->type('password', $password)
                ->type('password_confirmation', $password)
                ->press('REGISTER')
                ->assertSee('Before continuing, could you verify your email')
                ->assertPathIs('/email/verify');
        });
    }
}
