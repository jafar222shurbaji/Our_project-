<?php

use App\Http\Controllers\Dashboard\AuthDashboardController;
use App\Http\Controllers\Dashboard\DashboardCategoryController;
use App\Http\Controllers\Dashboard\DashboardEmployeeController;
use App\Http\Controllers\Dashboard\DashboardFabricController;
use App\Http\Controllers\Dashboard\DashboardPhotoController;
use App\Http\Controllers\Dashboard\DashboardProductController;
use App\Http\Controllers\Dashboard\DashboardWoodController;
use Illuminate\Support\Facades\Route;

// صفحة تسجيل الدخول
Route::get('/', [AuthDashboardController::class, 'showLogin'])->name('login');
Route::get('/auth/login', [AuthDashboardController::class, 'showLogin'])->name('login');
Route::post('/auth/login', [AuthDashboardController::class, 'login']);

// الصفحات المحمية (تتطلب تسجيل دخول)
Route::middleware(['auth:employee'])->group(function () {

    // تسجيل الخروج
    Route::post('/logout', [AuthDashboardController::class, 'logout'])->name('logout');


    // مجموعة صفحات الإدارة
    Route::prefix('admin')->group(function () {

        // إدارة الموظفين (للمدير أو مدير الموظفين فقط)
        Route::middleware(['role:Employee Manager,Admin'])->group(function () {
            Route::resource('employees', DashboardEmployeeController::class);
            Route::get('employees/{employee}/delete', [DashboardEmployeeController::class, 'delete'])->name('employees.delete');
        });

        // إدارة المنتجات والفئات (لمدير المنتجات فقط)
        Route::middleware(['role:Product Manager,Admin'])->group(function () {
            Route::resource('products', DashboardProductController::class);
            // داخل مجموعة Product Manager
            Route::get('/photos/{photo}', [DashboardPhotoController::class, 'destroyPhoto'])->name('photos.destroy');

            Route::get('products/{product}/delete', [DashboardProductController::class, 'delete'])->name('products.delete');
            Route::resource('categories', DashboardCategoryController::class);
            Route::get('categories/{category}/delete', [DashboardCategoryController::class, 'delete'])->name('categories.delete');
            Route::resource('woods', DashboardWoodController::class);
            Route::get('woods/{wood}/delete', [DashboardWoodController::class, 'delete'])->name('woods.delete');
            Route::resource('fabrics', DashboardFabricController::class);
            Route::get('fabrics/{fabric}/delete', [DashboardFabricController::class, 'delete'])->name('fabrics.delete');

        });

        // // إدارة الطلبات (لمدير الطلبات فقط)
        // Route::middleware(['role:Order Manager,Admin'])->group(function () {
        //     Route::resource('orders', OrderController::class);
        //     Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update.status');
        // });

    });

});
