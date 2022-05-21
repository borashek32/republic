<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Post;

class ExampleTest extends DuskTestCase
{
    public function testMainPage()
    {
        $this->post = Post::where('visability', 1)->first();
        
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(1000)
                ->assertDontSee('123')
                ->assertSee($this->post->title)
                ->assertDontSee('logged users')
                ->assertSee('Posts List');
        });
    }

    public function testOnePostPage()
    {
        $this->post = Post::where('visability', 1)->first();

        $this->browse(function (Browser $browser) {
            $browser->visit('/' . $this->post->id)
                ->pause(1000)
                ->assertDontSee('123')
                ->assertSee($this->post->title)
                ->assertSee('*Public post')
                ->assertDontSee('logged users')
                ->assertSee($this->post->description);
        });
    }

    public function testLoginPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->pause(1000)
                ->assertDontSee('123')
                ->assertSee('Remember me');
        });
    }

    public function testRegisterPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->pause(1000)
                ->assertDontSee('123')
                ->assertSee('Confirm Password');
        });
    }
}
