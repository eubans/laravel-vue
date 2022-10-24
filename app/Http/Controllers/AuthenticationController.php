<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Module;
use App\Models\UserExternalData;
use Laravel\Socialite\Facades\Socialite;
use App\Models\module_accesses;
use Auth;
use Hash;

class AuthenticationController extends Controller
{

    //this method adds new users
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'agreement' => 'required|accepted'
        ]);

        $user = User::create([
            'user_role_id'  => 1,
            'user_type_id'  => 2,
            'name'          => $fields['name'],
            'email'         => $fields['email'],
            'password'      => Hash::make($fields['password']),
        ]);

        //create token
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => User::getUserDetails($user->id),
            'token' => $token
        ];

        return response($response, 201);
    }

    //use this method to signin users
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required'
        ]);
        //check email
        $user = User::where('email', $fields['email'])->first();
        //check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['status' => false, 'message' => 'invalid email or password'], 401);
        }
        // Check url/module
        // $routes =Route::getRoutes();
        // $request = Request::create(); //put url you want to check
        // try{
        //     $routes->match($request);
        // }
        // catch(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e){
        //     // route doesnt exists
        // }

        //create token
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => User::getUserDetails($user->id),
            'user_access'=>module_accesses::getURL($user->user_type_id),
            'token' => $token
        ];
        return response($response, 201);
    }

    //this method send forgot password
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status;

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);

        // return response($response,201);
    }

    //this method resets password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);

        // return response($response,201);
    }

    //return user token
    public function user()
    {

        $response = [
            'status' => true,
            'message' => 'Login successful!',
            'data' => request()->user()->currentAccessToken()->token
        ];
        return response($response, 201);
    }

    // this method signs out users by removing tokens
    public function logout()
    {
        if (auth()) {
            auth()->user()->tokens()->delete();
        }
        $response = [
            'status' => true,
            'message' => 'Logout successfully',
        ];
        return response($response, 201);
    }
}
