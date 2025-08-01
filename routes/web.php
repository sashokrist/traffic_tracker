<?php

use App\Http\Controllers\Api\VisitController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VisitExportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/visits/export', [VisitExportController::class, 'export'])->name('visits.export')->middleware('auth');
    Route::get('/visits/download/{filename}', [VisitExportController::class, 'download'])->name('visits.download')->middleware('auth');
});
