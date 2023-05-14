<?php

namespace app\Http\Controllers;

use App\Models\AccountType;
use App\Models\AnnouncementImage;
use App\Models\Announcements;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use function PHPUnit\Framework\matches;

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
     * @return Application|\Illuminate\Contracts\View\Factory|View
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
     * @return Application|\Illuminate\Contracts\View\Factory|View
     */
    public function approve(int $id): view
    {
        User::where('id', $id)->update(['approved' => 1]);

        return $this->members();
    }

    /**
     * @param int $id
     * @return Application|\Illuminate\Contracts\View\Factory|View
     */
    public function reject(int $id): view
    {
        User::where('id', $id)->delete();

        return $this->members();
    }
}
