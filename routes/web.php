<?php

use App\Http\Controllers\Admin\AdminEquipmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\UserEquipmentController;
use Illuminate\Support\Facades\Auth;
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

//Route::get('/', function () {
//    return view('user.auth.login');
//});
//
//Auth::routes();
//
//Route::get('user/home', [HomeController::class, 'index'])->name('home');
//Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');

//Route::prefix('user/unix')->as('user.unix.')->group(function () {
//    Route::get('/equipment', [UserEquipmentController::class, 'equipment'])->name('equipment');
//    Route::post('/equipment', [UserEquipmentController::class, 'submit_equipment']);
//    Route::get('search_equipments', [UserEquipmentController::class, 'search_equipments'])->name('search_equipments');
//    Route::get('/equipment-list', [UserEquipmentController::class, 'equipment_list'])->name('equipment_list');
//    Route::get('/equipment-list-edit/{id}', [UserEquipmentController::class, 'equipment_list_edit'])->name('equipment_list_edit');
//    Route::put('/equipment-list-update/{id}', [UserEquipmentController::class, 'equipment_list_update'])->name('equipment_list_update');
//    Route::delete('/equipment-list-delete/{id}', [UserEquipmentController::class, 'equipment_destroy'])->name('equipment_destroy');
//    //    Route::get('/user-equipment-list', [UserEquipmentController::class, 'user_equipment_list'])->name('user_equipment_list');
//    //    Route::get('/equipment-data', [UserEquipmentController::class, 'equipment_data'])->name('equipment_data');
//});

Route::prefix('admin/unix')->as('admin.unix.')->group(function () {
//    Route::get('/equipment', [AdminEquipmentController::class, 'equipment'])->name('equipment');
//    Route::post('/equipment', [AdminEquipmentController::class, 'submit_equipment']);
//    Route::get('/equipment-list', [AdminEquipmentController::class, 'equipment_list'])->name('equipment_list');
//    Route::get('/equipment-data', [AdminEquipmentController::class, 'equipment_data'])->name('equipment_data');
//    Route::get('/user-equipment-list', [AdminEquipmentController::class, 'user_equipment_list'])->name('user_equipment_list');
//    Route::get('/user-equipment-data', [AdminEquipmentController::class, 'user_equipment_data'])->name('user_equipment_data');
//    Route::get('/equipment-list-edit/{id}', [AdminEquipmentController::class, 'equipment_list_edit'])->name('equipment_list_edit');
//    Route::put('/equipment-list-update/{id}', [AdminEquipmentController::class, 'equipment_list_update'])->name('equipment_list_update');
//    Route::delete('/equipment-list-delete/{id}', [AdminEquipmentController::class, 'equipment_destroy'])->name('equipment_destroy');
});
