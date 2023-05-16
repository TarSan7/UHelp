<?php

namespace app\Http\Controllers;

use App\Models\Fundraising;
use App\Models\FundraisingImage;
use Carbon\Carbon;
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

class FundraisingController extends Controller
{
    /**
     * @return View
     */
    public function allFundraising(): view
    {
        $fundraisingsDB = Fundraising::all()
            ->where('start_date', '<=', Carbon::now()->format('Y-m-d'))
            ->where('is_active', 1);
        $fundraisings = [];
        $xPosition = 0;
        $yPosition = 0;
        $width = 1;
        $height = 1;

        foreach ($fundraisingsDB as $key => $fundraising) {
            $fundraisings[] = [
                'x'         => $xPosition,
                'y'         => $yPosition,
                'w'         => $width,
                'h'         => $height,
                'i'         => $key,
                'id'        => $fundraising->id,
                'title'     => $fundraising->title,
                'shortInfo' => $fundraising->short_info,
                'sum'       => $fundraising->sum,
            ];

            $xPosition = ($xPosition + 1) % 3;
            $yPosition = $xPosition ?: $yPosition + 1;
        }

        return view(
            'fundraising',
            [
                'title'       => 'Fundraising',
                'user'        => Auth::check() ? json_encode(Auth::user()->toArray()) : null,
                'fundraising' => json_encode($fundraisings),
            ]
        );
    }

    /**
     * @return View
     */
    public function myFundraising(): View
    {
        $fundraising = Auth::user()->fundraising->toArray();

        return view('myFundraising', [
            'title'       => 'My fundraising',
            'user'        => Auth::check() ? json_encode(Auth::user()->toArray()) : null,
            'fundraising' => json_encode($fundraising)
        ]);
    }

    /**
     * @return View
     */
    public function createView(): View
    {
        return view('createFundraising', [
            'title' => 'Create',
            'user'  => Auth::check() ? json_encode(Auth::user()->toArray()) : null,
        ]);
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title'     => ['required', 'string', 'max:100'],
            'info'      => ['required', 'string'],
            'shortInfo' => ['required', 'string'],
            'startDate' => ['required'],
            'sum'       => ['required'],
            'images'    => ['required'],
            'link'      => ['required', 'string', 'regex:/^http[s]?:\/\/[a-zA-z\?\.\-_\/0-9]*$/'],
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
                'start_date'       => date("Y-m-d", strtotime($data['startDate'])),
                'sum'              => $data['sum'],
                'remaining_amount' => $data['sum'],
                'link'             => $data['link'],
            ];

            if ($data['id']) {
                Fundraising::where('id', $data['id'])->update($insert);
                $fundraising = Fundraising::where('id', $data['id'])->get()->first();
                FundraisingImage::where('fundraising_id', $data['id'])->delete();
                Storage::delete('fundraising/'.$data['id']);
            } else {
                $fundraising = Fundraising::create($insert);
            }

            foreach ($data['images'] as $key => $image) {
                $base64Image = str_replace('data:image/png;base64,', '', $image);
                $base64Image = str_replace(' ', '+', $base64Image);
                Storage::put('fundraising/' . $fundraising->id . '/' . $key .'.png', base64_decode($base64Image));

                FundraisingImage::create([
                    'path'           => 'fundraising/' . $fundraising->id . '/' . $key .'.png',
                    'is_main'        => false,
                    'fundraising_id' => $fundraising->id,
                ]);
            }
        });

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect('/my-fundraising');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        return view('editFundraising', [
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
        $fundraising = Fundraising::where('id', $id)->get()->toArray();
        $images      = FundraisingImage::where('fundraising_id', $id)->pluck('path')->toArray();

        $images = array_map(function ($url) {
            $img = Storage::get($url);

            return 'data:image/png;base64,' . base64_encode($img);
        }, $images);

        return new JsonResponse([$fundraising[0], $images], 201);
    }

    /**
     * @param int $id
     * @return View
     */
    public function closeView(int $id): View
    {
        return view('closeFundraising', [
            'title' => 'Close',
            'user'  => Auth::check() ? json_encode(Auth::user()->toArray()) : null,
            'id'    => $id,
        ]);
    }

    /**
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    public function close(Request $request): void
    {
        $this->validate(request(), [
            'cause' =>'required'
        ]);

        Fundraising::where('id', $request->get('id'))
            ->update(['is_active' => 0, 'cause' => $request->get('cause')]);
    }

    /**
     * @return View
     */
    public function getArchive(): View
    {
        $fundraising = Fundraising::where('is_active', 0)->get()->toArray();

        return view('archive',  [
            'title'       => 'Archive',
            'user'        => Auth::check() ? json_encode(Auth::user()->toArray()) : null,
            'fundraising' => json_encode($fundraising),
        ]);
    }

    public function detailsFundraising(int $id)
    {
        $fundraising = Fundraising::where('id', $id)->get();
        $images      = FundraisingImage::where('fundraising_id', $id)->pluck('path')->toArray();
        $volunteer   = $fundraising[0]->user;

        $images = array_map(function ($url) {
            $img = Storage::get($url);

            return ['url' => 'data:image/png;base64,' . base64_encode($img)];
        }, $images);

        return view('fundraisingDetails', [
            'title'       => 'Details',
            'user'        => Auth::check() ? json_encode(Auth::user()->toArray()) : null,
            'fundraising' => json_encode($fundraising->toArray()),
            'images'      => json_encode($images),
            'volunteer'   => json_encode($volunteer)
        ]);
    }
}
