<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileDeExController;

Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*Projects route*/
    Route::get('project', [ProjectController::class, 'index'])->name('project.index');
    Route::post('project', [ProjectController::class, 'store'])->name('project.store');
    Route::delete('project/{project}', [ProjectController::class, 'destroy'])->name('project.destroy');
    Route::get('project/{project}', [ProjectController::class, 'edit'])->name('project.edit');
    Route::put('/project/{project}', [ProjectController::class, 'update'])->name('project.update');

    /*Supplier route*/
    Route::get('supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('supplier', [SupplierController::class, 'store'])->name('supplier.store');
    Route::delete('supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    Route::get('supplier/{supplier}', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');

    /*khotiyan routes*/
    Route::get('/khotiyan',[ProfileDeExController::class,'index'])->name('khotiyan.index');
    Route::post('/khotiyan',[ProfileDeExController::class,'store'])->name('khotiyan.store');
    Route::delete('/khotiyan/{id}',[ProfileDeExController::class,'destroy'])->name('khotiyan.destroy');
    Route::get('/khotiyan/{id}',[ProfileDeExController::class,'edit'])->name('khotiyan.edit');
    Route::put('/khotiyan/{id}',[ProfileDeExController::class,'update'])->name('khotiyan.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
