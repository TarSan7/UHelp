<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AccountType;
use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        !$user->approved || Auth::attempt(['email' => $user->email, 'password' => $request->get('password')]);

        $details = [
            'title' => 'Реєстрація на платформі Ukraine Help',
            'body' => 'Ви успішно подали заявку на реєстрацію на платформі. Ваші документи будуть переглянуті та
                        невдовзі прийде лист з результатом розгляду заяви.'
        ];

        $this->sendMail($details, $request->get('email'));

        return new JsonResponse(['message' => 'Admin will check your account and contact.'], 201);
    }

    private function sendMail($details, $email)
    {
        Mail::to($email)->send(new \App\Mail\MyTestMail($details));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone'    => ['required', 'string', 'regex:/[0-9]{10}/'],
            'document' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function create(array $data)
    {
        $user = null;

        DB::transaction(function () use (&$user, $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
                'approved' => 0,
                'account_type_id' => $data['accountId'],
            ]);

            Document::create([
                'account_type_id' => $data['accountId'],
                'user_id'         => $user->id,
                'document'        => 'documents/' . $user->id,
                'status'          => Document::SENT_STATUS,
            ]);

            $base64Image = str_replace('data:image/png;base64,', '', $data['document']);
            $base64Image = str_replace(' ', '+', $base64Image);
            Storage::put('documents/' . $user->id . '.png', base64_decode($base64Image));
        });

        return $user;
    }

    /**
     * @return View|Redirector
     */
    public function getRegister()
    {
        if (Auth::user()) {
            return redirect('/fundraising');
        }

        $accountTypes = AccountType::REGISTER_ACCOUNT_TYPES;

        return view('register', ['title' => 'Register', 'accountTypes' => json_encode($accountTypes)]);
    }
}
