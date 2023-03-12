<?php

use App\Http\Controllers\AuthorController;
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
Route::get('/fetchauthors', [BookController::class, 'fetchauthors'])->name('fetchauthors');;

Route::get('/Author', [AuthorController::class, 'indexAuthor']);
Route::post('/storeAuthor', [AuthorController::class, 'storeAuthor'])->name('storeAuthor');
Route::get('/fetchallAuthor', [AuthorController::class, 'fetchAllAuthor'])->name('fetchAllAuthor');
Route::delete('/deleteAuthor', [AuthorController::class, 'deleteAuthor'])->name('deleteAuthor');
Route::get('/editAuthor', [AuthorController::class, 'editAuthor'])->name('editAuthor');
Route::post('/updateAuthor', [AuthorController::class, 'updateAuthor'])->name('updateAuthor');
