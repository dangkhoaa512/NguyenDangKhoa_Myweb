<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return "Test";
});

Route::get('/demo', [DemoController::class,'index']);
Route::get('/demo2', [DemoController::class,'index2']);
Route::get('/demo3', [DemoController::class,'index3']);
Route::get('/demo4/{id}', [DemoController::class,'index4']);
Route::get('/demo5/{id?}', [DemoController::class,'index5']);
Route::get('/demo6/{parram1}/{parram2}', [DemoController::class, 'index6']);

Route::prefix('admin')->name('admin.')->group(function () {

    // Authentication - không cần đăng nhập
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/forgotpass', [AuthController::class, 'forgotPassword'])->name('forgotpass');
    Route::post('/forgotpass', [AuthController::class, 'postForgotPassword'])->name('forgotpass.post');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset-password');
    Route::post('/reset-password', [AuthController::class, 'postResetPassword'])->name('reset-password.post');

    // Các route cần đăng nhập
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');
    Route::get('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password', [AuthController::class, 'postChangePassword'])->name('change-password.post');

   // Admin (1), Nhân viên (2), Thu ngân (3), Kho (4) — đều xem được danh sách sản phẩm
Route::middleware('role:1,2,3,4')->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
});

// Admin (1), Kho (4) — sửa sản phẩm
Route::middleware('role:1,4')->group(function () {
    Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{id}', [ProductController::class, 'update'])->name('products.update');
});

    // Chỉ Admin (1) — toàn quyền, bao gồm cả xóa
    Route::middleware('role:1')->group(function () {

    // Brands trash
        Route::get('trash/brands', [BrandController::class, 'trash'])->name('brands.trash');
        Route::patch('brands/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');
        Route::delete('brands/{id}/force-delete', [BrandController::class, 'forceDelete'])->name('brands.forceDelete');
        Route::patch('brands-trash/restore-all', [BrandController::class, 'restoreAll'])->name('brands.restoreAll');
        Route::delete('brands-trash/force-delete-all', [BrandController::class, 'forceDeleteAll'])->name('brands.forceDeleteAll');
        Route::resource('brands', BrandController::class);

        // Posts trash
        Route::get('trash/posts', [PostController::class, 'trash'])->name('posts.trash');
        Route::patch('posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
        Route::delete('posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('posts.forceDelete');
        Route::patch('posts-trash/restore-all', [PostController::class, 'restoreAll'])->name('posts.restoreAll');
        Route::delete('posts-trash/force-delete-all', [PostController::class, 'forceDeleteAll'])->name('posts.forceDeleteAll');
        Route::resource('posts', PostController::class);

    // Categories trash
        Route::get('trash/categories', [CategoryController::class, 'trash'])->name('categories.trash');
        Route::patch('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');
        Route::patch('categories-trash/restore-all', [CategoryController::class, 'restoreAll'])->name('categories.restoreAll');
        Route::delete('categories-trash/force-delete-all', [CategoryController::class, 'forceDeleteAll'])->name('categories.forceDeleteAll');

        Route::resource('categories', CategoryController::class);

        // Products trash
        Route::get('products-trash', [ProductController::class, 'trash'])->name('products.trash');
        Route::put('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
        Route::delete('products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.force-delete');
        Route::put('products-trash/restore-all', [ProductController::class, 'restoreAll'])->name('products.restoreAll');
        Route::delete('products-trash/force-delete-all', [ProductController::class, 'forceDeleteAll'])->name('products.forceDeleteAll');


        Route::get('trash/categories', [CategoryController::class, 'trash'])->name('categories.trash');
        Route::patch('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

        Route::resource('categories', CategoryController::class);
        Route::get('products-trash', [ProductController::class, 'trash'])->name('products.trash');
        Route::put('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
        Route::delete('products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.force-delete');
        Route::resource('categories', CategoryController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('users', UserController::class);
        Route::resource('posts', PostController::class);
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
        Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::delete('product-images/{id}', [ProductController::class, 'destroyImage'])
            ->name('product-images.destroy');
    });
});
});

Route::get('/test1', [ProductController::class, 'test1']);
Route::get('/test2', [ProductController::class, 'test2']);