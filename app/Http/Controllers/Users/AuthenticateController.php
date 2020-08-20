<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\User;



class AuthenticateController extends Controller
{
    public function loginUser( Request $request ) {

        $rules = array(

            'email' => 'required',
            'password' => 'required',
        );

        // let's check the guest filled in all the correct details :)
        $validator = Validator::make($request->all(), $rules);

            // Let's redirect back to login page if they have not

        if ( $validator->fails() ) {
            return redirect( '/' )
            ->withErrors( $validator )
            ->withInput( $request->except( 'password' ) );
            //Sends back error messages
        } else {
            // We will create an array of login information : )

            $loginData = array(
                'email' => $request->email,
                'password' => $request->password,
            );

            // Lets Login

            if ( Auth::attempt( $loginData ) ) {

                $user = User::where( 'email', $request->email )->first();

                if ( $user->account_activated == 0 ) {
                    return redirect( '/' )->with( 'error', 'Your Account Has Been Deactivated' );
                } else {
                    $subject = 'User Logged in';
                    $details = 'Administrator Logged In With Email '.$request->email;
                    $user_id  = Auth::user()->id;
                    \LogActivity::addToLog($subject,$details, $user_id);
                    return redirect( '/clients/dashboard' );
                }
            } else {
                // If not they can have this
                return redirect( '/' )->with( 'error', 'Invalid Email/Password' );
            }
        }

    }
}
