<?php

namespace app\Http\Controllers;

use App\Models\AccountType;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function members()
    {
        $members = User::whereIn('account_type_id', [AccountType::ACCOUNT_TYPE_VICTIM_ID, AccountType::ACCOUNT_TYPE_VOLUNTEER_ID])->get();
        $members = $members->map(function ($member) {
            $member->account_type_id = AccountType::REGISTER_ACCOUNT_TYPES[$member->account_type_id];
            return $member;
        })->toArray();

        return view('members', [
            'title'   => 'Members',
            'user'    => Auth::check() ? json_encode(Auth::user()->toArray()) : null,
            'members' => json_encode($members)
        ]);
    }

    /**
     * @param int $id
     * @return Application|Factory|View
     */
    public function watchMember(int $id)
    {
        $member   = User::where('id', $id)->get()->first();
        $document = $member->document;

        $file               = Storage::get($document->document . '.png');
        $document->document = 'data:image/png;base64,' . base64_encode($file);

        return view('member', [
            'title'   => 'Document',
            'user'    => Auth::check() ? json_encode(Auth::user()->toArray()) : null,
            'member'  => json_encode($document->toArray())
        ]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function approve(int $id): view
    {
        User::where('id', $id)->update(['approved' => 1]);

        $details = [
            'title' => 'Реєстрація на платформі Ukraine Help',
            'body'  => 'Ваші документи були переглянуті та
                        затверджені. Тепер ви можете увійти на платформу. Раді привітати Вас в родині UHelp!'
        ];

        $this->sendMail($details, User::where('id', $id)->get('email')->first());

        return $this->members();
    }

    /**
     * @param $details
     * @param $email
     * @return void
     */
    private function sendMail($details, $email)
    {
        Mail::to($email)->send(new \App\Mail\MyTestMail($details));
    }

    /**
     * @param int $id
     * @return View
     */
    public function reject(int $id): view
    {
        $details = [
            'title' => 'Реєстрація на платформі Ukraine Help',
            'body'  => 'Вашу заявку було скасовано через проблеми з документами. Перевірте документи та
                       спробуйте ще раз.'
        ];

        $this->sendMail($details, User::where('id', $id)->get('email')->first());

        User::where('id', $id)->delete();

        return $this->members();
    }
}
