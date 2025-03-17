<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Predis\Command\Argument\Search\SearchArguments;

Route::get('/login', [AuthenticationController::class, 'login'])->name('login');
Route::get('/register', [AuthenticationController::class, 'register'])->name('register');
Route::post('/login', [AuthenticationController::class, 'login_store']);
Route::post('/register', [AuthenticationController::class, 'register_store']);
Route::middleware('auth')->post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'welcome'])->name('dashboard');
    Route::post('/logout/all_devices', [AuthenticationController::class, 'logout_all_devices'])->name('logout.alldevices');
});

Route::get('/search', [SearchController::class, 'dashboard'])->name('search.dashboard')->middleware('auth');
// Route::get('/search/notification/file_download', [SearchController::class, 'file_download_notify'])->name('search.file_download_notify')->middleware('auth');
Route::post('search/download_file', [SearchController::class, 'download_file'])->name('search.download_file')->middleware('auth');


Route::get('/notification/show', [NotificationController::class, 'show'])->name('notification.show')->middleware('auth');
Route::post('/notification/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notification.markAsRead')->middleware('auth');
Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead')->middleware('auth');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');
Route::post('/profile/change_password', [ProfileController::class, 'change_password'])->name('profile.change_password');


Route::get('/test', [SearchController::class, 'test']);