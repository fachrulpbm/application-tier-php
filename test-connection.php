<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Test Koneksi Database</h2>";

// Test 1: Cek file exists
echo "<h3>1. Cek File Exists</h3>";
$files = [
    'app/config/Config.php',
    'app/config/Database.php',
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✅ {$file} - EXISTS<br>";
    } else {
        echo "❌ {$file} - NOT FOUND<br>";
    }
}

// Test 2: Load files
echo "<h3>2. Load Files</h3>";
try {
    require_once 'app/config/Config.php';
    echo "✅ Config.php loaded<br>";
    
    require_once 'app/config/Database.php';
    echo "✅ Database.php loaded<br>";
} catch (Exception $e) {
    echo "❌ Error loading: " . $e->getMessage() . "<br>";
    die();
}

// Test 3: Test database connection
echo "<h3>3. Test Database Connection</h3>";
try {
    $db = new Database();
    $conn = $db->getConnection();
    
    if ($conn) {
        echo "✅ Database connected successfully!<br>";
        echo "Database: " . Config::$DB_NAME . "<br>";
        
        // Test query
        $stmt = $conn->query("SELECT COUNT(*) as total FROM mahasiswas");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "✅ Total mahasiswa: " . $result['total'] . "<br>";
        
    } else {
        echo "❌ Database connection failed<br>";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<h3>4. Test Model</h3>";
try {
    require_once 'app/core/Model.php';
    require_once 'app/models/Mahasiswa.php';
    
    $mahasiswa = new Mahasiswa($conn);
    $stmt = $mahasiswa->getAll();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "✅ Model works! Data:<br>";
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "❌ Model Error: " . $e->getMessage() . "<br>";
}