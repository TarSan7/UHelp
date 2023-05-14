<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use PHPUnit\Util\Json;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        $this->validate(request(), [
            'email' => 'required|email',
            'password' =>'required'
        ]);

        $credentials = $request->only(['email', 'password']);
        $user        = User::where('email', $request['email'])->get()->first();

        if ($user->approved && Auth::attempt($credentials)) {
            return new JsonResponse([], 201);
        }

        return response()->json([
            'errors' => [
                'button' => ['Incorrect email or password or your account wasn\'t approved']
            ]
        ])->setStatusCode(422);
    }
}
