<?php

namespace app\Http\Controllers;

use App\Models\AnnouncementImage;
use App\Models\Announcements;
use App\Models\Fundraising;
use App\Models\FundraisingImage;
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

class HelpsController extends Controller
{
    /**
     * @return View
     */
    public function allAnnouncements(): view
    {
        $announcementsDB = Announcements::all()->where('is_active', 1);
        $announcements = [];
        $xPosition = 0;
        $yPosition = 0;
        $width = 1;
        $height = 1;

        foreach ($announcementsDB as $key => $announcement) {
            $announcements[] = [
                'x'         => $xPosition,
                'y'         => $yPosition,
                'w'         => $width,
                'h'         => $height,
                'i'         => $key,
                'id'        => $announcement->id,
                'title'     => $announcement->title,
                'shortInfo' => $announcement->short_info,
            ];

            $xPosition = ($xPosition + 1) % 3;
            $yPosition = $xPosition ?: $yPosition + 1;
        }

        return view(
            'announcements',
            [
                'title'         => 'Announcements',
                'user'          => Auth::check() ? json_encode(Auth::user()->toArray()) : null,
                'announcements' => json_encode($announcements),
            ]
        );
    }

    public function myAnnouncements()
    {
        $announcements = Auth::user()->announcements->toArray();

        return view('myAnnouncements', [
            'title'         => 'My Announcements',
            'user'          => Auth::check() ? json_encode(Auth::user()->toArray()) : null,
            'announcements' => json_encode($announcements)
        ]);
    }

    public function createView()
    {
        return view('createAnnouncement', [
            'title' => 'Create',
            'user'  => Auth::check() ? json_encode(Auth::user()->toArray()) : null,
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title'       => ['required', 'string', 'max:100'],
            'info'        => ['required', 'string'],
            'shortInfo'   => ['required', 'string'],
            'cardNumber'  => ['required', 'min:13', 'max:16'],
            'phoneNumber' => ['required', 'regex:/^\+380[0-9]{9}$/'],
            'images'      => ['required'],
        ]);
    }

    /**
     * Create instance
     *
     * @param Request $request
     * @return Application|JsonResponse|RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $this->validator($data)->validate();

        DB::transaction(function () use ($data) {
            $insert = [
                'title'            => $data['title'],
                'info'             => $data['info'],
                'short_info'       => $data['shortInfo'],
                'user_id'          => Auth::user()->id,
                'card_number'      => $data['cardNumber'],
                'phone_number'     => $data['phoneNumber'],
            ];

            if ($data['id']) {
                Announcements::where('id', $data['id'])->update($insert);
                $announcement = Announcements::where('id', $data['id'])->get()->first();
                AnnouncementImage::where('announcement_id', $data['id'])->delete();
            } else {
                $announcement = Announcements::create($insert);
            }

            foreach ($data['images'] as $key => $image) {
                $base64Image = str_replace('data:image/png;base64,', '', $image);
                $base64Image = str_replace(' ', '+', $base64Image);
                Storage::put('announcement/' . $announcement->id . '/' . substr($image, 0, 10) .'.png', base64_decode($base64Image));

                AnnouncementImage::updateOrCreate([
                    'path'            => 'announcement/' . $announcement->id . '/' . substr($image, 0, 10) .'.png',
                    'is_main'         => false,
                    'announcement_id' => $announcement->id,
                ]);
            }
        });

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect('/my-announcements');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        return view('editAnnouncement', [
            'title' => 'Edit',
            'user'  => Auth::check() ? json_encode(Auth::user()->toArray()) : null,
            'id'    => $id,
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getOne(int $id): JsonResponse
    {
        $announcement = Announcements::where('id', $id)->get()->toArray();
        $images       = AnnouncementImage::where('announcement_id', $id)->pluck('path')->toArray();

        $images = array_map(function ($url) {
            $img = Storage::get($url);

            return 'data:image/png;base64,' . base64_encode($img);
        }, $images);

        return new JsonResponse([$announcement[0], $images], 201);
    }

    public function closeView(int $id): View
    {
        return view('closeAnnouncement', [
            'title' => 'Close',
            'user'  => Auth::check() ? json_encode(Auth::user()->toArray()) : null,
            'id'    => $id,
        ]);
    }

    public function close(Request $request)
    {
        $this->validate(request(), [
            'cause' =>'required'
        ]);

        Announcements::where('id', $request->get('id'))
            ->update(['is_active' => 0, 'cause' => $request->get('cause')]);
    }


    /**
     * @param int $id
     * @return Application|\Illuminate\Contracts\View\Factory|View
     */
    public function detailsAnnouncement(int $id): view
    {
        $announcement = Announcements::where('id', $id)->get();
        $images       = AnnouncementImage::where('announcement_id', $id)->pluck('path')->toArray();
        $volunteer    = $announcement[0]->user;

        $images = array_map(function ($url) {
            $img = Storage::get($url);

            return ['url' => 'data:image/png;base64,' . base64_encode($img)];
        }, $images);

        return view('announcementDetails', [
            'title'        => 'Details',
            'user'         => Auth::check() ? json_encode(Auth::user()->toArray()) : null,
            'announcement' => json_encode($announcement->toArray()),
            'images'       => json_encode($images),
        ]);
    }
}
