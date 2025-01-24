<?php
require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;

try {
    // Initialize Firebase
    $factory = (new Factory)
        ->withServiceAccount(__DIR__ . '/file.json') // Path to your Firebase service account JSON
        ->withDatabaseUri('https://database-4e688-default-rtdb.firebaseio.com/'); // Replace with your database URL

    $database = $factory->createDatabase();
    $reference = $database->getReference('internet_tokens');
    $tokens = $reference->orderByChild('status')->equalTo('active')->getValue();

    echo json_encode(['success' => true, 'tokens' => $tokens]);
} catch (\Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>