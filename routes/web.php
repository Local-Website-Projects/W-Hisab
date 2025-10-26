<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileDeExController;
use App\Http\Controllers\DebitCreditController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FlatSellController;
use App\Http\Controllers\Product_purchase;

Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');

    /*Projects route*/
    Route::get('project', [ProjectController::class, 'index'])->name('project.index');
    Route::post('project', [ProjectController::class, 'store'])->name('project.store');
    Route::delete('project/{project}', [ProjectController::class, 'destroy'])->name('project.destroy');
    Route::get('project/{project}', [ProjectController::class, 'edit'])->name('project.edit');
    Route::put('/project/{project}', [ProjectController::class, 'update'])->name('project.update');

    /*Supplier route*/
    Route::get('/supplier-purchaser', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
    Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    Route::get('/supplier/{supplier}', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/supplier-purchaser/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');

    /*khotiyan routes*/
    Route::get('/khotiyan',[ProfileDeExController::class,'index'])->name('khotiyan.index');
    Route::post('/khotiyan',[ProfileDeExController::class,'store'])->name('khotiyan.store');
    Route::delete('/khotiyan/{id}',[ProfileDeExController::class,'destroy'])->name('khotiyan.destroy');
    Route::get('/khotiyan/{id}',[ProfileDeExController::class,'edit'])->name('khotiyan.edit');
    Route::put('/khotiyan/{id}',[ProfileDeExController::class,'update'])->name('khotiyan.update');

    /*cashbook routes*/
    Route::get('/cashbook',[DebitCreditController::class,'index'])->name('cashbook.index');
    Route::post('/cashbook',[DebitCreditController::class,'store'])->name('cashbook.store');
    Route::delete('/cashbook/{id}',[DebitCreditController::class,'destroy'])->name('cashbook.destroy');
    Route::get('/cashbook/{id}',[DebitCreditController::class,'edit'])->name('cashbook.edit');
    Route::put('/cashbook/{debitCredit}',[DebitCreditController::class,'update'])->name('cashbook.update');

    /*Reports routes*/
    Route::get('/report',[ProfileDeExController::class,'report'])->name('report.index');
    Route::post('/reportProfile',[DebitCreditController::class,'datewiseReport'])->name('report.cashbook');
    Route::post('/project-report',[DebitCreditController::class,'projectwiseReport'])->name('report.project');
    Route::post('/supplier-report',[DebitCreditController::class,'supplierwiseReport'])->name('report.supplier');


    /*products routes*/
    Route::get('/product',[ProductController::class,'index'])->name('product.index');
    Route::post('/product',[ProductController::class,'store'])->name('product.store');
    Route::get('/product/{id}',[ProductController::class,'edit'])->name('product.edit');
    Route::put('/product/{id}',[ProductController::class,'update'])->name('product.update');
    Route::delete('/product/{id}',[ProductController::class,'destroy'])->name('product.destroy');


    /*flat sell routes*/
    Route::get('/flatSale',[FlatSellController::class,'index'])->name('flat-sell.index');
    Route::post('/flatSale',[FlatSellController::class,'store'])->name('flat-sell.store');
    Route::get('/flatSale/{id}',[FlatSellController::class,'edit'])->name('flat-sell.edit');
    Route::put('/flatSale/{id}',[FlatSellController::class,'update'])->name('flat-sell.update');
    Route::delete('/flatSale/{id}',[FlatSellController::class,'destroy'])->name('flat-sell.destroy');

    /*product purchase routes*/
    Route::get('/purchase-product',[Product_purchase::class, 'index'])->name('purchase-product.index');
    Route::post('/purchase-product',[Product_purchase::class, 'store'])->name('purchase-product.store');
    Route::get('/purchase-product/{purchase_id}',[Product_purchase::class, 'edit'])->name('purchase-product.edit');
    Route::put('/purchase-product/{purchase_id}',[Product_purchase::class, 'update'])->name('purchase-product.update');
    Route::delete('/purchase-product/{purchase_id}',[Product_purchase::class, 'destroy'])->name('purchase-product.destroy');


});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
