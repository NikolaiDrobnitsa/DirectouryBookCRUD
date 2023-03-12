<?php

use App\Http\Controllers\BookController;
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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', [BookController::class, 'index']);
Route::post('/store', [BookController::class, 'store'])->name('store');
Route::get('/fetchall', [BookController::class, 'fetchAll'])->name('fetchAll');
Route::delete('/delete', [BookController::class, 'delete'])->name('delete');
Route::get('/edit', [BookController::class, 'edit'])->name('edit');
Route::post('/update', [BookController::class, 'update'])->name('update');
Route::get('/fetchauthors', [BookController::class, 'fetchauthors']);
