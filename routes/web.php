<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\WorkController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\SettingsController;

// ── Public ───────────────────────────────────────────────
Route::get('/', fn() => view('welcome'));
Route::get('/work', fn() => view('work'));
Route::get('/work/{slug}', fn() => view('work-detail'));
Route::get('/studio', fn() => view('studio'));
Route::get('/journal', fn() => view('journal'));

Route::get('/services', fn() => view('services'));

// ── Public API ────────────────────────────────────────────
Route::get('/api/journals', fn() => response()->json(\App\Models\Journal::published()->get()));
Route::get('/api/settings', function() {
    $S = \App\Models\SiteSetting::class;
    return response()->json([
        'brand'          => $S::get('brand',          ['name'=>'STORYTALE','tagline'=>'Stories That Sell','year'=>'2017','location'=>'Jakarta, ID']),
        'ticker_header'  => $S::get('ticker_header',  ['items'=>['★ Stories That Sell','★ Digital Marketing','★ Portfolio 2026','★ Content × Strategy']]),
        'ticker_hero'    => $S::get('ticker_hero',    ['items'=>['Social Media','Content Marketing','Paid Ads','SEO','Email Marketing','Branding']]),
        'ticker_clients' => $S::get('ticker_clients', ['items'=>['NIKE','SPOTIFY','ADOBE','STRIPE','FIGMA','NOTION']]),
        'contact'        => $S::get('contact',        ['email'=>'hello@storytale.id','phone'=>'+62 812-3456-7890','whatsapp'=>'6281234567890','address'=>'Jl. Kemang Raya No. 12','instagram_url'=>'#','tiktok_url'=>'#','linkedin_url'=>'#']),
        'hero'           => $S::get('hero',           ['headline_1'=>'WE','headline_2'=>'TELL','headline_3'=>'YOUR STORY.','description'=>'','stat_projects'=>'87','stat_years'=>'6+','stat_awards'=>'★4']),
        'studio'         => $S::get('studio',         ['hero_heading'=>'OUR STUDIO','hero_sub'=>'Jakarta, ID — Est. 2017','mission_quote'=>'We don\'t make content. We build stories that sell.','mission_desc'=>'','founded_text'=>'','stats'=>[],'process'=>[]]),
        'footer'         => $S::get('footer',         ['description'=>'Digital Marketing Agency · Est. 2017 · Jakarta, ID','instagram'=>'@storytale.id','tiktok'=>'@storytale.id','linkedin'=>'Storytale Agency']),
        'navbar'         => $S::get('navbar',         ['cta_text'=>"Let's Talk →",'cta_url'=>'#contact']),
    ]);
});
Route::get('/api/services', fn() => response()->json(\App\Models\Service::active()->get()));
Route::get('/api/team', fn() => response()->json(\App\Models\TeamMember::where('is_active',true)->orderBy('sort_order')->get()));

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
