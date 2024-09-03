<?php

use App\Http\Controllers\Api\AuthController;

// Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
// });

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function() {

});
