<?php

// Temporary route untuk fix image URLs - HAPUS SETELAH DIJALANKAN
Route::get('/admin-fix-urls-temp-{token}', function($token) {
    if ($token !== env('ADMIN_TOKEN', 'temporary-fix-token')) {
        return response('Unauthorized', 401);
    }

    \Illuminate\Support\Facades\Artisan::call('app:fix-image-urls');

    return response(\Illuminate\Support\Facades\Artisan::output(), 200, [
        'Content-Type' => 'text/plain; charset=utf-8'
    ]);
})->name('admin.fix-urls');
