<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A login form is available
     */
    public function test_the_user_can_see_login_page(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_blog_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/post/save', [
            'title' => 'Test Post',
            'body' => 'This is a test post content.',
        ]);

        $response->assertStatus(302);

        //Double assert that a new blog post was created in the database
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'body' => 'This is a test post content.',
        ]);
    }

    public function test_unauthenticated_user_can_not_create_post()
    {
        //$user = User::factory()->create();
        //$this->actingAs($user); //Authenticate as the user

        $response = $this->post('/post/save', [
            'title' => 'Test Post',
            'body' => 'This is a test post content.',
        ]);

        $response->assertStatus(302);
    }
}
