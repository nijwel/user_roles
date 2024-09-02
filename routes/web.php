<?php

use Illuminate\Support\Facades\Route;
use Nijwel\UserRoles\Controllers\RoleController;

Route::middleware(['auth'])->group(function () {
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('role/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('role/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('role/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('role/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::get('role/delete/{id}', [RoleController::class, 'destroy'])->name('roles.delete');
});
