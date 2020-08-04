<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\User;
use JWTAuth;


class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * Test registration
     */

    public function  testUserRegistration() {
        $data = [
            'firstname'=>'Francis',
            'lastname'=>'Kiryowa',
            'mobileno'=>'700162509',
            'password'=>'kiryowa1993',
            'password_confirmation'=>'kiryowa1993'
        ];
         //  Send post request
          $response = $this->json('POST', '/api/v1/register', $data);
         //   Assert that it was successful
          $response->assertStatus(201);
          // Assert we have received a token
          $json = $response->json();
          $this->assertSame('Sucessfully created an account please Log in', $json['message']);
    }

    public function testPhoneNumberConsistOfCharacters() {
        $data = [
            'firstname'=>'Francis',
            'lastname'=>'Kiryowa',
            'mobileno'=>'70016erer',
            'password'=>'kiryowa1993',
            'password_confirmation'=>'kiryowa1993'
        ];
        //  Send post request
        $response = $this->json('POST', '/api/v1/register', $data);
        //  Assert that it was successful
        $response->assertStatus(400);
        // Assert we have received a token
        $json = $response->json();

        $this->assertSame('The mobileno must be between 0 and 9 digits.', $response['mobileno'][0]);
    }

    public function testPhoneNumberConistsOfNotMoreThan9Digits() {
        $data = [
            'firstname'=>'Francis',
            'lastname'=>'Kiryowa',
            'mobileno'=>'70016250990',
            'password'=>'kiryowa1993',
            'password_confirmation'=>'kiryowa1993'
        ];
        // Send post request
        $response = $this->json('POST', '/api/v1/register', $data);
        // Assert that it was successful
        $response->assertStatus(400);

        $this->assertSame('The mobileno may not be greater than 9 characters.', $response['mobileno'][0]);
    }

    /**
     * LOGIN USER TESTS
     */
    public function testUserAuthentication() {
        $this->withoutExceptionHandling();
        $userRegistrationData = [
            'firstname'=>'Francis',
            'lastname'=>'Kiryowa',
            'mobileno'=>'700162509',
            'password'=>'kiryowa1993',
            'password_confirmation'=>'kiryowa1993'
        ];
        // Send post request
        $response = $this->json('POST', '/api/v1/register', $userRegistrationData);
        $loginData = [
            'mobileno'=>'700162509',
            'password'=>'kiryowa1993',
        ];
        //  Send post request
        $response1 = $this->json('POST', '/api/v1/authenticate',  $loginData);
        //  Assert that it was successful
        $response1->assertStatus(200);
        // Assert we have received a token
        $json = $response1->json();
        $this->assertSame(true, $json['success']);
    }

    /**
     * Function to assert wrong password
     */
    public function testUserAuthenticationWithWrongPassword() {
        $userRegistrationData = [
            'firstname'=>'Francis',
            'lastname'=>'Kiryowa',
            'mobileno'=>'700162509',
            'password'=>'kiryowa1993',
            'password_confirmation'=>'kiryowa1993'
        ];
        // Send post request
        $response = $this->json('POST', '/api/v1/register', $userRegistrationData);
        $loginData = [
            'mobileno'=>'700162509',
            'password'=>'kiryowa199',
        ];
        //  Send post request
        $response1 = $this->json('POST', '/api/v1/authenticate',  $loginData);
        //  Assert that it was successful
        $response1->assertStatus(400);
        // Assert we have received a token
        $json = $response1->json();
        $this->assertSame('Wrong password', $response1['password'][0]);
    }

    /**
     * Function to show phone number does not exist
     */
    public function testUserAuthenticationWithWrongPhoneNumber() {
        $userRegistrationData = [
            'firstname'=>'Francis',
            'lastname'=>'Kiryowa',
            'mobileno'=>'700162509',
            'password'=>'kiryowa1993',
            'password_confirmation'=>'kiryowa1993'
        ];
        // Send post request
        $response = $this->json('POST', '/api/v1/register', $userRegistrationData);
        $loginData = [
            'mobileno'=>'700162500',
            'password'=>'kiryowa1993',
        ];
        //  Send post request
        $response1 = $this->json('POST', '/api/v1/authenticate',  $loginData);
        //  Assert that it was successful
        $response1->assertStatus(400);
        // Assert we have received a token
        $json = $response1->json();
        $this->assertSame('Phone Number does not exist', $response1['mobileno'][0]);
    }

    /**
     * function to show phone number contains characters
     */
    public function testUserAuthenticationWithPhoneNumberContainingCharacters() {
        $userRegistrationData = [
            'firstname'=>'Francis',
            'lastname'=>'Kiryowa',
            'mobileno'=>'700162509',
            'password'=>'kiryowa1993',
            'password_confirmation'=>'kiryowa1993'
        ];
        // Send post request
        $response = $this->json('POST', '/api/v1/register', $userRegistrationData);
        $loginData = [
            'mobileno'=>'7001625er',
            'password'=>'kiryowa1993',
        ];
        //  Send post request
        $response1 = $this->json('POST', '/api/v1/authenticate',  $loginData);
        //  Assert that it was successful
        $response1->assertStatus(400);
        // Assert we have received a token
        $json = $response1->json();
        $this->assertSame('Phone number should consist of only digits', $response1['mobileno'][0]);
    }

    //TESTING GET AUTHENTICATED USER

    public function testGetAuthenticatedUser() {
        $userRegistrationData = [
            'firstname'=>'Francis',
            'lastname'=>'Kiryowa',
            'mobileno'=>'700162509',
            'password'=>'kiryowa1993',
            'password_confirmation'=>'kiryowa1993'
        ];
        // Send post request
        $response = $this->json('POST', '/api/v1/register', $userRegistrationData);
        $loginData = [
            'mobileno'=>'700162509',
            'password'=>'kiryowa1993',
        ];
        //  Send post request
        $response1 = $this->json('POST', '/api/v1/authenticate',  $loginData);
        //  Assert that it was successful
        $response1->assertStatus(200);
        // Assert we have received a token
        $json = $response1->json();
        $token = $json['auth_token'];

        $response2 = $this->withHeaders([
            'Authorization' => $token,
        ])->json('GET', '/api/v1/user');

        $this->assertSame(true, $json['success']);
    }

    /**
     * Function to check token is absent
     */
    public function testTokenAbscent() {
        $userRegistrationData = [
            'firstname'=>'Francis',
            'lastname'=>'Kiryowa',
            'mobileno'=>'700162509',
            'password'=>'kiryowa1993',
            'password_confirmation'=>'kiryowa1993'
        ];
        // Send post request
        $response = $this->json('POST', '/api/v1/register', $userRegistrationData);
        $loginData = [
            'mobileno'=>'700162509',
            'password'=>'kiryowa1993',
        ];
        //  Send post request
        $response1 = $this->json('POST', '/api/v1/authenticate',  $loginData);
        //  Assert that it was successful
        $response1->assertStatus(200);
        // Assert we have received a token
        $json = $response1->json();
        $token = $json['auth_token'];

        $response2 = $this->json('GET', '/api/v1/user');
        $response2->assertStatus(200);
        $json1 = $response2->json();
        $this->assertSame('Authorization Token not found', $json1['status']);
    }

    /**
     * Token is invalid
     */
    public function testException() {
        $userRegistrationData = [
            'firstname'=>'Francis',
            'lastname'=>'Kiryowa',
            'mobileno'=>'700162509',
            'password'=>'kiryowa1993',
            'password_confirmation'=>'kiryowa1993'
        ];
        // Send post request
        $response = $this->json('POST', '/api/v1/register', $userRegistrationData);
        $loginData = [
            'mobileno'=>'700162509',
            'password'=>'kiryowa1993',
        ];
        //  Send post request
        $response1 = $this->json('POST', '/api/v1/authenticate',  $loginData);
        //  Assert that it was successful
        $response1->assertStatus(200);
        // Assert we have received a token
        $json = $response1->json();
        $token = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvbG9jYWx
        ob3N0XC9hcGlcL3YxXC9hdXRoZW50aWNhdGUiLCJpYXQiOjE1OTM2OTE1MTcsImV4cCI6MTU5MzY5NTExNywibmJmIjoxNTk
        zNjkxNTE3LCJqdGkiOiJJWjE0SlZvSkJ0bERnTTRkIiwic3ViIjoxLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM
        5NzE1M2ExNGUwYjA0NzU0NmFhIiwiZmlyc3RuYW1lIjpudWxsLCJsYXN0bmFtZSI6Iktpcnlvd2EiLCJtb2JpbGVubyI6Ij
        cwMDE2MjUwOSIsInVzZXJfaWQiO';

        $response2 = $this->withHeaders([
            'Authorization' => $token,
        ])->json('GET', '/api/v1/user');

        $json1 = $response2->json();
        $this->assertSame('Token is Invalid', $json1['status']);
    }
}
