<?php

use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('ajax', [TeacherController::class, 'index'])->name('index');
Route::get('all-teacher', [TeacherController::class, 'allData'])->name('allData');
Route::post('store', [TeacherController::class, 'store'])->name('store');
Route::get('edit/{id}', [TeacherController::class, 'edit'])->name('edit');
Route::post('update/{id}', [TeacherController::class, 'update'])->name('update');
