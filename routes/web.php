<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::redirect('', 'catalog');
Route::get('catalog', [\App\Http\Controllers\TestController::class, 'index'])->name('test.index');


// Auth pages
Route::middleware(['guest'])->group(function () {
    // Registration
    Route::get('register', [\App\Http\Controllers\RegisterController::class, 'index'])->name('register');
    Route::post('register', [\App\Http\Controllers\RegisterController::class, 'register']);
    // Login
    Route::get('login', [\App\Http\Controllers\LoginController::class, 'index'])->name('login');
    Route::post('login', [\App\Http\Controllers\LoginController::class, 'login']);
});
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::get('logout', [\App\Http\Controllers\LogoutController::class, 'perform'])->name('logout');
});

// Test pages
Route::prefix('tests')->controller(\App\Http\Controllers\TestController::class)->group(function () {
    Route::middleware(['auth', 'regex.id'])->group(function () {
        // Create Test
        Route::get('create', 'createTestForm')->name('test.create');
        Route::post('create', 'store')->name('test.store');
        // Edit Test
        Route::get('{test}/edit', 'editTestForm')->name('test.edit');
        Route::post('{test}/update', 'update')->name('test.update');
        // Remove Test
        Route::delete('{test}/remove', 'removeTest')->name('test.remove');
    });
    // Show Test page
    Route::get('{test}','showTest')->name('test.show')->middleware('regex.id');
});

// Profile pages
Route::prefix('profile')->middleware('regex.id')->controller(\App\Http\Controllers\ProfileController::class)->group(function () {
    // Show profile page
    Route::get('{user}', 'showProfile')->name('profile.show');

    Route::middleware(['auth'])->group(function () {
        // Edit profile
        Route::get('{user}/edit', 'editProfileForm')->name('profile.edit');
        // Update user credentials
        Route::post('{user}/change_phone','changePhone')->name('profile.change_phone');
        Route::post('{user}/change_password','changePassword')->name('profile.change_password');
        Route::post('{user}/change_credentials','changeCredentials')->name('profile.change_credentials');
    });
});

// Category pages
Route::prefix('categories')->middleware(['regex.id'])->controller(\App\Http\Controllers\CategoryController::class)->group(function () {
    // All categories page
    Route::get('', 'index')->name('category.index');
    // Show all products by category
    Route::get('{category}','productsByCategory')->name('category.show');
});
