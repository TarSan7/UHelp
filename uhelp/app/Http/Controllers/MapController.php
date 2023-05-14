<?php

namespace app\Http\Controllers;

use App\Models\Map;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MapController extends Controller
{
    /**
     * @return Application|\Illuminate\Contracts\View\Factory|View
     */
    public function getMap()
    {
        $map = Map::all()->toArray();
        return view('map', [
            'title' => 'Map',
            'user'  => Auth::check() ? json_encode(Auth::user()->toArray()) : null,
            'map'   => json_encode($map)
        ]);
    }

    /**
     * @return Application|\Illuminate\Contracts\View\Factory|View
     */
    public function addMap()
    {
        return view('addMap', [
            'title' => 'Add Map',
            'user'  => Auth::check() ? json_encode(Auth::user()->toArray()) : null,
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => ['required', 'string', 'max:100'],
            'address'   => ['required', 'string'],
            'city'      => ['required', 'string'],
            'latitude'  => ['required'],
            'longitude' => ['required'],
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

        Map::create([
            'name'      => $data['name'],
            'address'   => $data['address'],
            'city'      => $data['city'],
            'latitude'  => $data['latitude'],
            'longitude' => $data['longitude'],
        ]);

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect('/map');
    }
}
