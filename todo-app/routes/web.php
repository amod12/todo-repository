<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;

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
    return view('todos.home');
});
route::resource('todos', TodoController::class)->middleware('auth');
route::post('/todo/update-status/{id}', [TodoController::class, 'updateStatus']);
route::post('/todos/update/${todoId}', [TodoController::class, 'edit']);


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('password-change', [AuthController::class, 'showchangePasswordForm'])->name('password.change');
Route::post('password-change', [AuthController::class, 'changePassword'])->name('password.change');

