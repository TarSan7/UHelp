<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $fundraising = \App\Models\Fundraising::limit(5)->get();
    $fundraising = $fundraising->map(function ($item) {
        $image = $item->image->pluck('path')[0];
        $img = Storage::get($image);

        return [
            'title'   => $item->title,
            'content' => $item->short_info,
            'url'     =>  'data:image/png;base64,' . base64_encode($img)
        ];
    })->toArray();

    return view('app', ['title' => 'UHelp', 'fundraising' => json_encode($fundraising)]);
});

Route::get('/login', function () {
    if (Auth::user()) {
        return redirect('/fundraising');
    }

    return view('login', ['title' => 'Login']);
});

Route::post('/login', 'App\Http\Controllers\Auth\LoginController')->name('login');

Route::get('/logout', function () {
    Auth::logout();

    return redirect('/');
});

Route::get('/archive', [App\Http\Controllers\FundraisingController::class, 'getArchive']);

Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'getRegister']);
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::get('/fundraising', [App\Http\Controllers\FundraisingController::class, 'allFundraising'])->name('fundraising');
Route::get('/details-fundraising/{id}', [App\Http\Controllers\FundraisingController::class, 'detailsFundraising']);
Route::get('/details-announcement/{id}', [App\Http\Controllers\HelpsController::class, 'detailsAnnouncement']);
Route::get('/announcements', [App\Http\Controllers\HelpsController::class, 'allAnnouncements'])->name('announcements');

Route::get('/map', [App\Http\Controllers\MapController::class, 'getMap']);

Route::group(['middleware' => 'auth:web'], function() {
    Route::get('/add-map', [App\Http\Controllers\MapController::class, 'addMap']);
    Route::post('/create-map', [App\Http\Controllers\MapController::class, 'create']);

    Route::get('/members', [App\Http\Controllers\AdminController::class, 'members']);
    Route::get('/watch-member/{id}', [App\Http\Controllers\AdminController::class, 'watchMember']);
    Route::get('/approve/{id}', [App\Http\Controllers\AdminController::class, 'approve']);
    Route::get('/reject/{id}', [App\Http\Controllers\AdminController::class, 'reject']);

    Route::get('/my-fundraising', [App\Http\Controllers\FundraisingController::class, 'myFundraising']);
    Route::get('/add-fundraising', [App\Http\Controllers\FundraisingController::class, 'createView']);
    Route::get('/edit-fundraising/{id}', [App\Http\Controllers\FundraisingController::class, 'edit']);
    Route::get('/close-fundraising/{id}', [App\Http\Controllers\FundraisingController::class, 'closeView']);
    Route::post('/close-fundraising', [App\Http\Controllers\FundraisingController::class, 'close']);
    Route::post('/create-edit-fundraising', [App\Http\Controllers\FundraisingController::class, 'create']);
    Route::get('/get-fundraising/{id}', [App\Http\Controllers\FundraisingController::class, 'getOne']);

    Route::get('/my-announcements', [App\Http\Controllers\HelpsController::class, 'myAnnouncements']);
    Route::get('/add-announcement', [App\Http\Controllers\HelpsController::class, 'createView']);
    Route::get('/edit-announcement/{id}', [App\Http\Controllers\HelpsController::class, 'edit']);
    Route::get('/close-announcement/{id}', [App\Http\Controllers\HelpsController::class, 'closeView']);
    Route::post('/close-announcement', [App\Http\Controllers\HelpsController::class, 'close']);
    Route::post('/create-edit-announcement', [App\Http\Controllers\HelpsController::class, 'create']);
    Route::get('/get-announcement/{id}', [App\Http\Controllers\HelpsController::class, 'getOne']);
});
