<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\UserController;



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

Route::middleware('auth')->group(function () {
    Route::resource('blog-posts', BlogPostController::class);
    Route::get('export', [ExcelController::class, 'export'])->name('excel.export');
    Route::get('import', [ExcelController::class, 'showImportForm'])->name('excel.import.form');
    Route::post('import', [ExcelController::class, 'import'])->name('excel.import');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
