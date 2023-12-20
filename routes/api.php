<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\ReportController;

Route::post('/login', [UserController::class, 'login']);

//AUTH
Route::group(['middleware' => 'auth:api'], function() {
    Route::middleware('ValidateUser:user')->group(function(){
        Route::prefix('church')->group(function () {
            Route::prefix('report')->group(function () {
                Route::post('/create/activity', [ReportController::class, 'CreateActivityReport']);
                Route::post('/generate/pdf', [ReportController::class, 'GeneratePDFReport']);
                Route::post('/filter/date', [ReportController::class, 'FilterDateRangeReport']);
            });

            Route::get('/my/generated/reports', [ReportController::class, 'GetMyPDFReports']);

            Route::prefix('dashboard')->group(function () {
                Route::get('/view', [ReportController::class, 'PastorsDashboard']);
            });
        });
    });
});
