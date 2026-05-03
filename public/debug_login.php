<?php
// A special file to debug the login issue directly.

// We need the database connection file
require_once '../App/core/Database.php';

echo "<div style='font-family: sans-serif; padding: 20px;'>";
echo "<h1>Login Debug Test</h1>";

// Connect to the database
$database = new Database();
$conn = $database->getConnection();
if (!$conn) {
    die("<h2>Result: FAILED TO CONNECT TO DATABASE.</h2>");
}
echo "<p>Successfully connected to the database.</p>";

// Try to find the admin user
$email = 'admin@example.com';
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    echo "<p>Successfully found the user 'admin@example.com'.</p>";
    echo "<p>Password stored in database is: <b>" . htmlspecialchars($user['password']) . "</b></p>";

    // Now, let's test the password
    $password_from_form = 'admin123';

    if ($user['password'] == $password_from_form) {
        echo "<h2 style='color: green;'>SUCCESS: The password matches! The login should work.</h2>";
    } else {
        echo "<h2 style='color: red;'>FAILURE: The password in the database does NOT match 'admin123'.</h2>";
    }

} else {
    echo "<h2 style='color: red;'>FAILURE: Could not find a user with the email 'admin@example.com'.</h2>";
}

echo "</div>";