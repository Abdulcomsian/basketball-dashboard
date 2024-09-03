<?php

use App\Http\Controllers\OtpConfirmationController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\WorkoutsController;
use App\Http\Controllers\Admin\LevelsController;
use App\Http\Controllers\Admin\SkillsController;
use App\Http\Controllers\Admin\UploadVideoController;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    // Define route for blocking/unblocking users
    Route::get('user/{id}/toggle-block', [UsersController::class, 'toggleBlock'])->name('user.toggle.block');

    Route::resource('workouts', 'WorkoutsController');
    Route::resource('levels', 'LevelsController');
    Route::resource('skills', 'SkillsController');
    Route::resource('videos', 'UploadVideoController');

});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});

Route::get('otp-confirmation/{username}', [OtpConfirmationController::class, 'index'])->name('otp.confirmation');
Route::post('otp-confirmation', [OtpConfirmationController::class, 'verification'])->name('password.otp.verification');

Route::get('reset-password/{username}/{otp}', [ResetPasswordController::class, 'index'])->name('reset.password');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('reset-password');
