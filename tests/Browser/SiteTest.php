<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Post;

class SiteTest extends DuskTestCase
{
    public function testUnloggedUserCanSeeOnlyPublicPosts()
    {
        $this->post = Post::where('visability', 1)->first();
        
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertDontSee('123')
                ->assertSee($this->post->title)
                ->assertDontSee('logged users')
                ->assertSee('Posts List')
                ->assertDontSee('logged users')
                ->assertSee('*Public post');
        });
    }

    public function testUnloggedUserCanSeeOnePublicPost()
    {
        $this->post = Post::where('visability', 1)->first();

        $this->browse(function (Browser $browser) {
            $browser->visit('/' . $this->post->id)
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
                ->assertDontSee('123')
                ->assertSee('Remember me');
        });
    }

    public function testRegisterPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->assertDontSee('123')
                ->assertSee('Confirm Password');
        });
    }
}
