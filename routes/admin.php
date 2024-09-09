<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminEquipmentController;
use Illuminate\Support\Facades\Route;
Route::middleware(['guest:admin'])->group(function () {
    Route::post('register',    [AdminController::class, 'AdminRegisteration'])->name('register');
    Route::get('/',            [AdminController::class, 'AdminLoginForm'])->name('login.form');
    Route::post('postlogin',   [AdminController::class, 'AdminLogin'])->name('login');
});
Route::middleware(['auth:admin'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'Dashboard'])->name('dashboard');
    Route::post('logout',      [AdminController::class, 'AdminLogout'])->name('logout');

    Route::get('/equipment', [AdminEquipmentController::class, 'equipment'])->name('equipment');
    Route::post('/equipment', [AdminEquipmentController::class, 'submit_equipment']);
    Route::get('/equipment-list', [AdminEquipmentController::class, 'equipment_list'])->name('equipment_list');
    Route::get('/equipment-data', [AdminEquipmentController::class, 'equipment_data'])->name('equipment_data');
    Route::get('/user-equipment-list', [AdminEquipmentController::class, 'user_equipment_list'])->name('user_equipment_list');
    Route::get('/user-equipment-data', [AdminEquipmentController::class, 'user_equipment_data'])->name('user_equipment_data');
    Route::get('/equipment-list-edit/{id}', [AdminEquipmentController::class, 'equipment_list_edit'])->name('equipment_list_edit');
    Route::put('/equipment-list-update/{id}', [AdminEquipmentController::class, 'equipment_list_update'])->name('equipment_list_update');
    Route::delete('/equipment-list-delete/{id}', [AdminEquipmentController::class, 'equipment_destroy'])->name('equipment_destroy');
});
