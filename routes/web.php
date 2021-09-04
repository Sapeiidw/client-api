<?php

use App\Http\Controllers\SSOController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get("/redirect", [SSOController::class,'redirect'])->name('redirect');
Route::get("/callback", [SSOController::class,'callback'])->name('callback');
Route::get("/login_with_sso", [SSOController::class,'login_with_sso'])->name('login_with_sso');
Route::get("/authuser", function(Request $request) {
    $access_token = $request->session()->get("access_token");
    $response = Http::withHeaders([
        "Accept" => "application/json",
        "Authorization" => "Bearer " . $access_token
    ])->get(env('SSO_URL')."/api/user");
    return $response->json();
});