<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_user_can_register_with_valid_credentials()
    {
        $this->artisan('migrate:fresh --seed');
        $response = $this->post(route('register'), [
            'name'                  => 'nat',
            'email'                 => 'mail@mail.ru',
            'phone'                 => '10000000000',
            'password'              => '11111111',
            'password_confirmation' => '11111111'
        ]);
        $response = $this->assertDatabaseHas('users', [
            'name' => 'nat'
        ]);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $response = $this->post('/login', [
            'email'    => 'mail@mail.ru',
            'password' => '11111111',
        ]);

        $response = $this->get(RouteServiceProvider::HOME);
        $response->assertStatus(302);
    }

    public function test_admin_can_authenticate_using_the_login_screen()
    {
        $response = $this->post('/login', [
            'email'    => 'admin@gmail.com',
            'password' => '11111111',
        ]);

        $response = $this->get(RouteServiceProvider::HOME);
        $response->assertSee('Manage all posts');
        $response->assertOk();
    }


    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $this->post('/login', [
            'email' => 'mail@mail.ru',
            'password' => 'wrong-password',
        ]);

        $response = $this->assertGuest($guard = null);
    }
}
