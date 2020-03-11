<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Mockery;

class AuthControllerTest extends TestCase
{
   
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_authenticate_using_google()
    {
        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('id')->andReturn(rand())
                        ->shouldReceive('email')->andReturn('johnDoe@gmail.com')
                        ->shouldReceive('name')->andReturn('John Doe')
                        ->shouldReceive('getAvatar')->andReturn('https://en.gravatar.com/userimage');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::ShouldReceive('driver')->andReturn($provider);

        $this->get('/oauth/google/callback')->assertStatus(302);
    }


       /**
     * @test
     */
    public function can_authenticate_using_facebook()
    {
        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('id')->andReturn(rand())
                        ->shouldReceive('email')->andReturn('johnDoe@gmail.com')
                        ->shouldReceive('name')->andReturn('John Doe')
                        ->shouldReceive('getAvatar')->andReturn('https://en.gravatar.com/userimage');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::ShouldReceive('driver')->andReturn($provider);

        $this->get('/oauth/facebook/callback')->assertStatus(302);
    }
}
