<?php

namespace Tests\Unit\User;

use App\Models\User;
use App\Models\Post;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_can_get_any_own_post()
    {
        $post = Post::where('user_id', 2)->first();

        $response = $this->post('/login', [
            'email'    => 'user@gmail.com',
            'password' => '22222222',
        ]);

        $response->assertLocation('/dashboard/posts')->with($post->title);
    }

    public function test_user_can_delete_own_post()
    {
        $post = Post::where('user_id', 2)->first();

        $response = $this->post('/login', [
            'email'    => 'user@gmail.com',
            'password' => '22222222',
        ]);

        $response = $this->delete(route('posts.destroy', $post->id));
        $response->assertStatus(302);
        $response->assertDontSee($post->title);
        $response->assertLocation('/dashboard/posts');
    }

    public function test_user_can_edit_own_post()
    {
        $post = Post::where('user_id', 2)->first();

        $response = $this->post('/login', [
            'email'    => 'user@gmail.com',
            'password' => '22222222',
        ]);

        $response = $this->delete(route('posts.update', $post->id));
        $response->assertStatus(302);
        $response->assertLocation('/dashboard/posts');
    }

    public function test_user_can_get_edit_photo_page()
    {
        $response = $this->post('/login', [
            'email'    => 'user@gmail.com',
            'password' => '22222222',
        ]);

        $response = $this->get('/user/profile');
        $response->assertSee("Profile");
        $response->assertOk();
    }
}
