<?php

use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|-------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/






Route::post('/post-registration', "App\Http\Controllers\RegistrationController@postRegistration")->name('register.post')->middleware(["guest"]);
Route::post('/login/post', "App\Http\Controllers\SessionsController@store")->name('login.post')->middleware(['is_verify_email']);
Route::get('/verification/{token}', 'App\Http\Controllers\RegistrationController@verification')->name('user.verify');
Route::post("/forgot-password", "App\Http\Controllers\ForgotPasswordController@forgotPasswordForm")->name("forgot.password");
Route::post("/reset-password/{token}", "App\Http\Controllers\ForgotPasswordController@resetPassword");



Route::middleware(["auth:sanctum"])->group(function () {

    Route::get("/get-all-users", "App\Http\Controllers\SessionsController@getAllUsers");
    Route::get("/send-request/{to}", "App\Http\Controllers\FriendRequestController@sendRequest");
    Route::get("/sent-request", "App\Http\Controllers\FriendRequestController@getAllSentRequests");
    Route::get("/accept-request/{from}", "App\Http\Controllers\FriendRequestController@acceptRequest");
    Route::get("/get-received-requests", "App\Http\Controllers\FriendRequestController@getAllReceivedRequests");
    Route::get("/get-all-friends", "App\Http\Controllers\FriendRequestController@getAllFriends");

    Route::get("/read-message/{id}", "App\Http\Controllers\MessageController@readMessage");

    Route::post("/group-message", "App\Http\Controllers\MessageController@sendGroupMessage");
    Route::post("/send-message", "App\Http\Controllers\MessageController@sendMessage");
    Route::get("/get-conversation/{with}", "App\Http\Controllers\MessageController@getConversation");
    Route::get("/get-group-conversation/{group}", "App\Http\Controllers\MessageController@getGroupConversation");
    Route::post("/create-group", "App\Http\Controllers\GroupController@createGroup");
    Route::get("/get-groups", "App\Http\Controllers\GroupController@getGroups");


});
