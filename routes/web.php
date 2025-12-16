<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

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

Route::get('/', [PageController::class, 'index']);
Route::get('/preview/{id}', [PageController::class, 'show']);
Route::get('/landing/{slug}', [PageController::class, 'landingBySlug'])->name('pages.landing');
Route::resource('/pages',PageController::class);
Route::get('/page-builder', function () {
    return view('page-builder.index');
});

Route::prefix('cms')->group(function () {
    Route::get('/page-builder',[PageController::class,'index'])->name('page-builder.index');
});