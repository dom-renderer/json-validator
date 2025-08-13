<?php

use Illuminate\Support\Facades\Route;

Route::redirect('', 'login');

Route::middleware(['auth'])->group(function () {

    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::resource('policy-holders', \App\Http\Controllers\PolicyHolderController::class);
    
    Route::post('country-list', [\App\Helpers\Helper::class, 'getCountries'])->name('country-list');
    Route::post('state-list', [\App\Helpers\Helper::class, 'getStatesByCountry'])->name('state-list');
    Route::post('city-list', [\App\Helpers\Helper::class, 'getCitiesByState'])->name('city-list');
    Route::post('user-list', [\App\Helpers\Helper::class, 'getUsers'])->name('user-list');
    Route::post('holder-list', [\App\Helpers\Helper::class, 'getHolders'])->name('holder-list');
    Route::post('document-list', [\App\Helpers\Helper::class, 'getDocuments'])->name('document-list');


    Route::get('get-docs', [\App\Http\Controllers\CaseController::class, 'getDocs'])->name('get-docs');

    Route::get('settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');

    Route::get('cases/create/{id?}', [\App\Http\Controllers\CaseController::class, 'create'])->name('cases.create');
    Route::get('cases/edit/{id?}', [\App\Http\Controllers\CaseController::class, 'edit'])->name('cases.edit');
    Route::get('cases', [\App\Http\Controllers\CaseController::class, 'index'])->name('cases.index');

    Route::post('cases/submission', [\App\Http\Controllers\CaseController::class, 'submission'])->name('case.submission');
    Route::post('cases/auto-save', [\App\Http\Controllers\CaseController::class, 'autoSave'])->name('case.auto-save');

    Route::post('upload-document', [\App\Http\Controllers\CaseController::class, 'uploadDoc'])->name('upload-document');
});