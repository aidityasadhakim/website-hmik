<?php

use App\Http\Controllers\API\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get("posts", [PostsController::class, "index"]);
Route::controller(PostsController::class)->group(function () {
    Route::get("posts", "index");
    Route::get("posts/{slug}", "show");
    Route::post("posts/create", "store");
    Route::post("posts/update/{slug}", "update");
    Route::post("posts/delete/{post:slug}", "destroy");
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
