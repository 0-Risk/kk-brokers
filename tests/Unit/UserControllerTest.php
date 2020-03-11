<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use App\User;
use JWTAuth;


class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

        /**
     * @test
     * Test registration
     */
    public function  testUserRegistration() {
        //  Users's data
          $data = [
               'firstname'=>'Francis',
               'lastname'=>'Kiryowa',
               'mobileno'=>'700162509',
               'password'=>'kiryowa1993',
               'password_confirmation'=>'kiryowa1993'
          ];
         //  Send post request
          $response = $this->json('POST', '/api/v1/register', $data);
          $response->dump();
         //   Assert that it was successful
          $response->assertStatus(201);
          // Assert we have received a token
          $json = $response->json();
          $this->assertSame(true, $json['success']);
          $this->assertSame('Sucessfully created an account please Log in', $json['message']);

      }
  
}
