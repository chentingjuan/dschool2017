<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    // protected $redirectTo = '/frontend';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
        // $this->middleware('guest');
    // }


     /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resetPasswordHandler(Request $request)
    {
        $this->validate($request, $this->rules());
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        // return ($this->credentials($request));
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                // return $user;
                $this->resetPassword($user, $password);
            }
        );

        // if ($request->wantsJson()) {
        //     if ($response == Password::PASSWORD_RESET) {
        //         return response()->json(Json::response(null, trans('passwords.reset')));
        //     } else {
        //         return response()->json(Json::response($request->input('email'), trans($response), 202));
        //     }
        // }
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
        ? ["success"=>true,"status" => "success"] : ["success"=>false,"status" => "fail"];


        //   return $response == Password::PASSWORD_RESET
        // ? $this->sendResetResponse($response)
        // : $this->sendResetFailedResponse($request, $response);
    }

    public function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => bcrypt($password),
            'remember_token' => Str::random(60),
        ])->save();

        if(!$user->activated){
            redirect ('/');
        } else {
            $this->guard()->login($user);
        }
    }

}
