
<?php
require __DIR__ . '/autoload.php';

use Kreait\Firebase\Factory;

try {
   // Initialize Firebase
   $factory = (new Factory)
   ->withServiceAccount(__DIR__ . '/file.json') // Path to your Firebase service account JSON
   ->withDatabaseUri('https://database-4e688-default-rtdb.firebaseio.com/'); // Replace with your database URL

$database = $factory->createDatabase();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number_of_tokens = htmlspecialchars($_POST['number_of_tokens']);
    $expiration_time = htmlspecialchars($_POST['expiration_time']);
    if ($number_of_tokens > 0 && !empty($expiration_time)) {
        for ($i = 0; $i < $number_of_tokens; $i++) {
            $newtoken = bin2hex(random_bytes(4)); // Generate a 16-character random token

             // Save the token in the database
            $database->getReference('internet_tokens/' . uniqid())->set([
                'token' => $newtoken,
                'status' => 'active',
                'expiry' => $expiration_time,
            ]);
        }

    }else {
            echo "Invalid input!";
    }
}
} catch (\Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
header('Location: admin.html');
exit();
?>

