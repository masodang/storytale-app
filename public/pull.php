<?php
// Git pull endpoint - jalankan sekali untuk pull latest commits
// Access: https://storytale.danlainlain.id/pull.php?token=pull-now

if (($_GET['token'] ?? '') !== 'pull-now') {
    http_response_code(401);
    die('Unauthorized');
}

echo "<pre style='font-family: monospace; background: #000; color: #0f0; padding: 20px;'>";
echo "\n🚀 Pulling latest commits from git...\n\n";

// Change to app directory
$appDir = dirname(__DIR__);
chdir($appDir);

// Run git pull
$output = shell_exec('cd ' . escapeshellarg($appDir) . ' && git pull origin main 2>&1');
echo $output;

echo "\n✅ Git pull complete!\n";
echo "\nFiles should be updated now. You can run the fix via: /fix.php?token=fix-now\n";
echo "\n</pre>";
?>
