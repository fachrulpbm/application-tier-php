<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json; charset=UTF-8");

echo "Testing Direct Controller Access...\n\n";

// Load files
require_once 'app/config/Config.php';
require_once 'app/config/Database.php';
require_once 'app/core/Model.php';
require_once 'app/core/Controller.php';
require_once 'app/models/Mahasiswa.php';
require_once 'app/controllers/MahasiswaController.php';

try {
    echo "Files loaded successfully!\n\n";
    
    // Test instantiate controller
    $controller = new MahasiswaController();
    echo "Controller instantiated!\n\n";
    
    // Test method exists
    if (method_exists($controller, 'index')) {
        echo "Method 'index' exists!\n\n";
        
        // Call the method
        echo "Calling index()...\n\n";
        $controller->index();
        
    } else {
        echo "ERROR: Method 'index' not found!\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "\nTrace:\n" . $e->getTraceAsString();
}