<?php

use App\Http\Controllers\User\UserEquipmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\StaffController;
Route::middleware(['guest:staff'])->group(function () {
    Route::get('/',            [StaffController::class, 'StaffLoginForm'])->name('login.form');
    Route::post('postlogin',   [StaffController::class, 'StaffLogin'])->name('login');
});
Route::middleware(['auth:staff'])->group(function () {
    Route::get('dashboard',   [StaffController::class, 'Dashboard'])->name('dashboard');
    Route::post('logout',      [StaffController::class, 'StaffLogout'])->name('logout');

//    Route::prefix('/unix')->as('unix.')->group(function () {
        Route::get('/equipment', [UserEquipmentController::class, 'equipment'])->name('equipment');
        Route::post('/equipment', [UserEquipmentController::class, 'submit_equipment']);
        Route::get('search_equipments', [UserEquipmentController::class, 'search_equipments'])->name('search_equipments');
        Route::get('/equipment-list', [UserEquipmentController::class, 'equipment_list'])->name('equipment_list');
        Route::get('/equipment-list-edit/{id}', [UserEquipmentController::class, 'equipment_list_edit'])->name('equipment_list_edit');
        Route::put('/equipment-list-update/{id}', [UserEquipmentController::class, 'equipment_list_update'])->name('equipment_list_update');
        Route::delete('/equipment-list-delete/{id}', [UserEquipmentController::class, 'equipment_destroy'])->name('equipment_destroy');
//    });
});

