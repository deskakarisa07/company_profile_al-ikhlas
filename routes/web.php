<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CompanyProfileController as AdminCompanyProfileController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EducationUnitController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog-detail/{blog}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::middleware('admin')->group(function () {
        Route::get('/', fn () => redirect()->route('admin.dashboard'));
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/articles/export-pdf', [ArticleController::class, 'exportPdf'])->name('articles.export-pdf');
        Route::resource('articles', ArticleController::class);
        Route::get('/profiles', [AdminCompanyProfileController::class, 'index'])->name('profiles.index');
        Route::put('/profiles', [AdminCompanyProfileController::class, 'update'])->name('profiles.update');
        Route::resource('units', EducationUnitController::class);
        Route::resource('galleries', AdminGalleryController::class);
        Route::get('/messages', [ContactMessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
        Route::patch('/messages/{message}/read', [ContactMessageController::class, 'markAsRead'])->name('messages.read');
        Route::delete('/messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');
    });
});
