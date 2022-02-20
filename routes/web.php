<?php

use App\Http\Controllers\StudentController;
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

route::get('/crud-page',[StudentController::class,'index']);
route::post('/saveData',[StudentController::class,'store']);
route::get('/fetching-data',[StudentController::class,'fetchingData']);