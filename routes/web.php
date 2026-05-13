<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\WorkController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ApiController;

// ── Public pages ──────────────────────────────────────────
Route::get('/',        [PageController::class, 'welcome']);
Route::get('/work',    [PageController::class, 'work']);
Route::get('/work/{slug}', [PageController::class, 'workDetail']);
Route::get('/studio',  [PageController::class, 'studio']);
Route::get('/journal', [PageController::class, 'journal']);
Route::get('/services',[PageController::class, 'services']);

// ── Public API ────────────────────────────────────────────
Route::get('/api/journals',  [ApiController::class, 'journals']);
Route::get('/api/settings',  [ApiController::class, 'settings']);
Route::get('/api/services',  [ApiController::class, 'services']);
Route::get('/api/team',      [ApiController::class, 'team']);
Route::get('/api/projects',  [ApiController::class, 'projects']);

// ── Admin auth ────────────────────────────────────────────
Route::get('/admin/login',  [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout',[AuthController::class, 'logout'])->name('admin.logout');

// ── Admin panel ───────────────────────────────────────────
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/work');

    Route::resource('work', WorkController::class)->except(['show']);
    Route::post('work/{work}/toggle-status',   [WorkController::class, 'toggleStatus'])->name('work.toggle-status');
    Route::post('work/{work}/toggle-featured', [WorkController::class, 'toggleFeatured'])->name('work.toggle-featured');

    Route::post('upload',          [UploadController::class, 'store'])->name('upload');
    Route::delete('images/{image}',[UploadController::class, 'destroyImage'])->name('images.destroy');

    Route::resource('journal', JournalController::class)->except(['show']);
    Route::resource('service', ServiceController::class)->only(['index','edit','update']);
    Route::post('service/{service}/toggle-active', [ServiceController::class,'toggleActive'])->name('service.toggle-active');
    Route::get('settings', [SettingsController::class,'index'])->name('settings');
    Route::put('settings', [SettingsController::class,'update'])->name('settings.update');

    Route::get('about', [AboutController::class,'index'])->name('about.index');
    Route::post('about', [AboutController::class,'store'])->name('about.store');
    Route::put('about/{about}', [AboutController::class,'update'])->name('about.update');
    Route::delete('about/{about}', [AboutController::class,'destroy'])->name('about.destroy');
});
