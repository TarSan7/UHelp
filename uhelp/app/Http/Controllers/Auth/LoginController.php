<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
        dd($credentials);

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }

        return ['message' => 'Auth failed'];
    }
}
