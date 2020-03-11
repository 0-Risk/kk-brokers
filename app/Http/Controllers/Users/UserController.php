<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use JWTAuth;


class UserController extends Controller {
    /**
     * Function to authenticate users
     */
    public function authenticate( Request $request ) {

        $messages = [
            'mobileno.regex' => 'Phone number should consist of only digits',
            'mobileno.max' => 'Phone number must have 9 digits',
            'mobileno.min' => 'Phone number must have 9 digits',
        ];
        $validator = Validator::make($request->all(), [
            'mobileno' => 'required|string|max:9|min:9|regex:/^[0-9]+$/',
            'password' => 'required|string|min:6',
        ], $messages);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $credentials = $request->only( 'mobileno', 'password' );

        $user = User::where( 'mobileno', $request->get('mobileno'))->first();
        if($user) {
            $customlaims = [
                'firstname' => $user->firtsname, 
                'lastname' => $user->lastname,
                'mobileno'=>$user->mobileno, 
                'user_id'=>$user->id
            ];
            try {

                if (!$token = JWTAuth::claims($customlaims)->attempt($credentials)) {
                    $validator->getMessageBag()->add('password', 'Wrong password');
                    return response()->json($validator->errors(), 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }
            $generatedToken = [
                'success' => true,
                'auth_token' => 'Bearer '. $token,
            ];

            return response()->json($generatedToken, 200);

        }else{
            try {

                if (!$token = JWTAuth::attempt($credentials)) {
                    $validator->getMessageBag()->add('mobileno', 'Phone Number does not exist');
                    return response()->json($validator->errors(), 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

        }
    }

    /**
     * Function to register users
     * 
     */

    public function register( Request $request ) {
        $messages = [
            'phonenumber.digits_between' => 'Phone number should consist of only digits',
            'phonenumber.max' => 'Phone number should consist of only 9 digits',
        ];

        $validator  = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'mobileno'=>'required|string|max:9|min:9|unique:users|digits_between:0,9',
            'password' => 'required|string|min:6|confirmed',
        ], $messages);

        if ( $validator->fails() ) {
            return response()->json( $validator->errors(), 400 );
        }

        $user = User::create( [
            'firstname' => ucfirst($request->get( 'firstname' )) ,
            'lastname' => ucfirst($request->get( 'lastname' )),
            'mobileno' => $request->get( 'mobileno' ),
            'password' => Hash::make( $request->get( 'password' ) ),
        ] );

        return response()->json([
            'success' => true,
            'message' => 'Sucessfully created an account please Log in'
        ], 201);
    }

    /**
     * Function to get  authenticated user
     */
    public function getAuthenticatedUser() {
        try {

            if ( ! $user = JWTAuth::parseToken()->authenticate() ) {
                return response()->json( ['user_not_found'], 404 );
            }

        } catch ( Tymon\JWTAuth\Exceptions\TokenExpiredException $e ) {

            return response()->json( ['token_expired'], $e->getStatusCode() );

        } catch ( Tymon\JWTAuth\Exceptions\TokenInvalidException $e ) {

            return response()->json( ['token_invalid'], $e->getStatusCode() );

        } catch ( Tymon\JWTAuth\Exceptions\JWTException $e ) {

            return response()->json( ['token_absent'], $e->getStatusCode() );

        }

        return response()->json( compact( 'user' ) );
    }
}
