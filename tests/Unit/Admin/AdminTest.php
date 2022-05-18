<?php

namespace Tests\Unit\Admin;

use App\Models\User;
use App\Models\Post;
use Tests\TestCase;

class AdminTest extends TestCase
{
    public function test_admin_can_get_users_page()
    {
        $response = $this->post('/login', [
            'email'    => 'admin@gmail.com',
            'password' => '11111111',
        ]);

        $response = $this->get('/dashboard/users');
        $response->assertSee('Manage users');
        $response->assertOk();
    }

    public function test_admin_can_get_edit_user_photo_page()
    {
        $response = $this->post('/login', [
            'email'    => 'admin@gmail.com',
            'password' => '11111111',
        ]);

        $user = User::find(10);

        $response = $this->get('/dashboard/users/10/edit');
        $response->assertSee("Photo");
        $response->assertOk();
    }

    public function test_admin_can_get_other_user_post()
    {
        $user_id = random_int(2, User::count());
        $post    = Post::where('user_id', $user_id)->first();

        $response = $this->post('/login', [
            'email'    => 'admin@gmail.com',
            'password' => '11111111',
        ]);

        $response->assertLocation('/dashboard/posts')->with($post->title);
    }

    public function test_admin_can_delete_posts()
    {
        $post_id = random_int(1, Post::count());
        $post    = Post::where('id', $post_id)->first();

        $response = $this->post('/login', [
            'email'    => 'admin@gmail.com',
            'password' => '11111111',
        ]);

        $response = $this->delete(route('posts.destroy', $post_id));
        $response->assertStatus(302);
        $response->assertDontSee($post->title);
        $response->assertLocation('/dashboard/posts');
    }

    public function test_admin_can_change_post_visability()
    {
        $post = Post::where('visability', '1')->first();

        $response = $this->post('/login', [
            'email'    => 'admin@gmail.com',
            'password' => '11111111',
        ]);

        $response = $this->put(route('posts.update', $post->id), [
            'visability' => '0'
        ]);

        $response = $this->post(route('logout', 1));
        $response->assertLocation('/');
        $response->assertDontSee($post->title);
    }
}
