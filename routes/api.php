<?php

use Illuminate\Http\Request;
use App\Helpers\ErrorHandler;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PostsController;
use App\Http\Controllers\API\MembersController;
use App\Http\Controllers\API\DepartmentsController;
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\CategoryController;

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
    Route::post("posts/create", "store")->middleware('auth:api');
    Route::post("posts/update/{slug}", "update")->middleware('auth:api');
    Route::post("posts/delete/{post:slug}", "destroy")->middleware('auth:api');
});

Route::controller(ErrorHandler::class)->group(function () {
    Route::get("/notauthenticated", "notAuthenticated")->name("notauthenticated");
});

Route::controller(AuthenticationController::class)->group(function () {
    Route::post("/login", "authenticate");
    Route::post("/logout", "logout")->middleware('auth:api');
    Route::post("/register", "register")->middleware('auth:api');
});

Route::controller(MembersController::class)->group(function () {
    Route::post("members/create", "createMember")->middleware('auth:api');
    Route::get("members/department/{department}", "showMemberByDepartment");
    Route::get('members/{name}/{departments}', "showMemberByName");
    Route::post('members/update/{id}', "updateMember")->middleware('auth:api');
});

Route::controller(DepartmentsController::class)->group(function () {
    Route::post("departments/create", "create")->middleware('auth:api');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get("/category", "showAllCategory");
    Route::get("/subcategory", "showAllSubCategory");
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
