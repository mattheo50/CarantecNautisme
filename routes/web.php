<?php

use App\Http\Controllers\AcnDiveModifyController;
use App\Http\Controllers\AcnDivesController;
use App\Http\Controllers\AcnDiveCreationController;
use Illuminate\Http\Request;
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
    return view("welcome");
})->name("welcome");

Route::get('/dives', function () {
    return AcnDivesController::getAllDivesValues();
})->middleware(['auth'])->name("dives");

Route::get('/dives/informations/{id}', function ($id){
    return AcnDivesController::getAllDiveInformation($id);
})->name("dives_informations");

Route::post('/dives/register', function (Request $request){
    return AcnDivesController::register($request);
})->name("membersDivesRegister");

Route::post('/dives/unregister', function (Request $request){
    return AcnDivesController::unregister($request);
})->name("membersDivesUnregister");

Route::get('/dashboard', function () {
    return view('dashboard', ["name" => auth()->user()->MEM_NAME, "surname" => auth()->user()->MEM_SURNAME]);
})->middleware(['auth'])->name('dashboard');

Route::get('/secretary', function () {
    return view('secretary', ["name" => auth()->user()->MEM_NAME, "surname" => auth()->user()->MEM_SURNAME, "function" => auth()->user()->FUN_LABEL]);
})->middleware(['auth'])->middleware('isSecretary')->name("secretary");

Route::get('/diveCreation', function () {
    return AcnDiveCreationController::getAll();
})->middleware(['auth'])->middleware('isManager')->name("diveCreation");

Route::get('/diveModify', function () {
    return AcnDiveModifyController::getAll();
})->middleware(['auth'])->middleware('isDirectorOrManager')->name("diveModifyleware f");

Route::post('diveCreationForm', [AcnDiveCreationController::class, 'create'])->name("diveCreationForm");

Route::post('diveModifyForm', [AcnDiveModifyController::class, 'modify'])->name('diveModifyForm');

require __DIR__.'/auth.php';
