<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\User;

class RegisterTest extends DuskTestCase
{
    public function testUserCanRegisterWithVaildCredentials()
    {
        $user = Faker::create();
        $password = $user->password; 

        $this->browse(function (Browser $browser) use($user, $password) {
            $browser->visit('/register')
                ->type('name', $user->name)
                ->type('email', $user->email)
                ->type('password', $password)
                ->type('password_confirmation', $password)
                ->press('REGISTER')
                ->assertPathIs('/email/verify');
        });
    }
}
