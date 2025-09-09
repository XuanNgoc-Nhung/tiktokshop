<?php
// Test language switching
require_once '../vendor/autoload.php';

$app = require_once '../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get language from URL parameter
$lang = $_GET['lang'] ?? 'vi';
app()->setLocale($lang);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Language Test</title>
</head>
<body>
    <h1>Language Test - <?= $lang ?></h1>
    <p>Dashboard: <?= __('admin::auth.dashboard') ?></p>
    <p>User Management: <?= __('admin::auth.user_management') ?></p>
    <p>Order Management: <?= __('admin::auth.order_management') ?></p>
    <p>Product Management: <?= __('admin::auth.product_management') ?></p>
    <p>Analytics: <?= __('admin::auth.analytics') ?></p>
    <p>System Settings: <?= __('admin::auth.system_settings') ?></p>
    
    <h2>Test Links:</h2>
    <a href="?lang=vi">Tiếng Việt</a> | 
    <a href="?lang=en">English</a> | 
    <a href="?lang=zh">中文</a> | 
    <a href="?lang=ja">日本語</a> | 
    <a href="?lang=bn">বাংলা</a>
</body>
</html>
