<?php

use App\Http\Controllers\Admin\AddEbookController;
use App\Http\Controllers\Admin\AddUsersController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ExcelUploadController;
use App\Http\Controllers\ImportSiswaController;
use App\Http\Controllers\Auth\LoginUsersController;
use App\Http\Controllers\ClassRoom\PagesClassSchoolController;
use App\Http\Controllers\Ebook\CanvasController;
use App\Http\Controllers\Ebook\EbookPDFController;
use GuzzleHttp\Middleware;

Route::get('/', function () {
return view('welcome');
});


Route::get('/upload-excel', [ExcelUploadController::class, 'form']);
Route::post('/upload-excel', [ExcelUploadController::class, 'import']);

// Routing untuk masing-masing Kelas
Route::get('/kelas7', [PagesClassSchoolController::class, 'Grade7th'])->name('kelas7')->middleware('auth');
Route::get('/kelas8', [PagesClassSchoolController::class, 'Grade8th'])->name('kelas8')->middleware('auth');
Route::get('/kelas9', [PagesClassSchoolController::class, 'Grade9th'])->name('kelas9')->middleware('auth');


Route::get('/admin', [AdminController::class, 'Admin'])->name('admin')->middleware('auth');

// usersAdd
Route::get('/add-users', [AddUsersController::class, 'Create'])->name('add-users')->middleware('auth');
Route::post('/add-users', [AddUsersController::class, 'Store'])->name('add-users')->middleware('auth');
Route::delete('/delete-user/{id}', [AddUsersController::class, 'deleteUsers'])->name('delete-user')->middleware('auth');

// EbookAdd
Route::get('add-ebook', [AddEbookController::class, 'Create'])->name('add-ebook')->middleware('auth');
Route::post('add-ebook', [AddEbookController::class, 'Store'])->name('add-ebook')->middleware('auth');
Route::delete('/delete-ebook/{id}', [AddEbookController::class, 'deleteUsers'])->name('delete-user')->middleware('auth');

Route::get('/login', [LoginUsersController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginUsersController::class, 'login']);
Route::post('/logout', [LoginUsersController::class, 'logout'])->name('logout');


// routing ebook
Route::get('/ebook/{file_pdf}', [EbookPDFController::class, 'ebook'])->name('Ebook')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::post('/drawings/{file_pdf}', [CanvasController::class, 'store']);
    Route::get('/drawings/{file_pdf}', [CanvasController::class, 'get']);
});

