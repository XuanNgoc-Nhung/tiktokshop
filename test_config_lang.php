<?php
// Test file để kiểm tra ngôn ngữ cấu hình
require_once 'vendor/autoload.php';

// Load Laravel app
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test các key ngôn ngữ
echo "Testing Vietnamese translations:\n";
echo "system_configuration: " . __('admin::cms.system_configuration', [], 'vi') . "\n";
echo "config_saved_success: " . __('admin::cms.config_saved_success', [], 'vi') . "\n";
echo "close: " . __('admin::cms.close', [], 'vi') . "\n";

echo "\nTesting English translations:\n";
echo "system_configuration: " . __('admin::cms.system_configuration', [], 'en') . "\n";
echo "config_saved_success: " . __('admin::cms.config_saved_success', [], 'en') . "\n";
echo "close: " . __('admin::cms.close', [], 'en') . "\n";
?>
