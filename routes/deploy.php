<?php

// Simple deploy endpoint - HAPUS SETELAH DIGUNAKAN
Route::post('/deploy-webhook', function(\Illuminate\Http\Request $request) {
    $token = $request->query('token');

    if ($token !== env('DEPLOY_TOKEN', 'temp-deploy-token')) {
        return response('Unauthorized', 401);
    }

    try {
        // Pull latest from git
        $output = shell_exec('cd ' . base_path() . ' && git pull origin main 2>&1');

        // Run fix command
        \Illuminate\Support\Facades\Artisan::call('app:fix-image-urls');

        return response(
            "✅ Deploy & Fix berhasil!\n\n" .
            "Git pull output:\n" . $output . "\n\n" .
            "Fix command output:\n" .
            \Illuminate\Support\Facades\Artisan::output(),
            200,
            ['Content-Type' => 'text/plain; charset=utf-8']
        );
    } catch (\Exception $e) {
        return response("❌ Error: " . $e->getMessage(), 500);
    }
})->name('deploy');
