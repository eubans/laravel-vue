<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\SocialAuthController;
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

//Testing
Route::get('/testing', [AuthenticationController::class, 'testingGround']);
//login user
Route::post('/login', [AuthenticationController::class, 'login']);

//register new user
Route::post('/register', [AuthenticationController::class, 'register']);

//forgot password
Route::post('/forgot-password', [AuthenticationController::class, 'forgotPassword']);

//reset password
Route::post('/reset-password/{token}', [AuthenticationController::class, 'resetPassword'])->name('password.reset');

// web

//using middleware
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/user', [AuthenticationController::class, 'user']);
    Route::post('/logout', [AuthenticationController::class, 'logout']);

    // SETTINGS CONTROLLER
    Route::get('/settings/users', [SettingsController::class, 'users']);
    Route::get('/settings/users/{id}', [SettingsController::class, 'userById']);
    Route::post('/settings/users/save', [SettingsController::class, 'userSave']);
    Route::post('/settings/users/update', [SettingsController::class, 'userUpdate']);

    Route::get('/settings/user-types', [SettingsController::class, 'userTypes']);
    Route::get('/settings/user-types/{id}', [SettingsController::class, 'userTypeById']);

    Route::get('/settings/user-roles', [SettingsController::class, 'userRoles']);
    Route::get('/settings/user-roles/{id}', [SettingsController::class, 'userRoleById']);
    Route::post('/settings/user-roles/save', [SettingsController::class, 'userRoleSave']);
    Route::post('/settings/user-roles/update', [SettingsController::class, 'userRoleUpdate']);

    // TEST
    // Route::get('/settings/user/test', [SettingsController::class, 'test'])->middleware('auth');

    Route::get('/settings/user-status', [SettingsController::class, 'userStatus']);
    Route::get('/settings/user-active-status', [SettingsController::class, 'userActiveStatus']);

    // NOTIFICATION CONTROLLER
    Route::get('/notification', [NotificationController::class, 'index']);
    Route::post('/notification/get-by-user', [NotificationController::class, 'getNotificationsByUser']);
    Route::post('/notification/set-as-read', [NotificationController::class, 'setNotificationAsRead']);






});
// Route::group(['middleware' => ['admin']], function() {
//      // SETTINGS CONTROLLER
//      Route::get('/settings/users', [SettingsController::class, 'users']);
//      Route::get('/settings/users/{id}', [SettingsController::class, 'userById']);
//      Route::post('/settings/users/save', [SettingsController::class, 'userSave']);
//      Route::post('/settings/users/update', [SettingsController::class, 'userUpdate']);

//      Route::get('/settings/user-types', [SettingsController::class, 'userTypes']);
//      Route::get('/settings/user-types/{id}', [SettingsController::class, 'userTypeById']);

//      Route::get('/settings/user-roles', [SettingsController::class, 'userRoles']);
//      Route::get('/settings/user-roles/{id}', [SettingsController::class, 'userRoleById']);
//      Route::post('/settings/user-roles/save', [SettingsController::class, 'userRoleSave']);
//      Route::post('/settings/user-roles/update', [SettingsController::class, 'userRoleUpdate']);
// });
// Route::group(['middleware' => ['guest']], function() {
//     Route::get('/help', [SettingsController::class, 'help']);
// });


