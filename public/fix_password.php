<?php
// This is a special script to securely reset the admin password.
require_once '../App/core/Database.php';

$admin_email = 'tanjid@gmail.com';
$new_password = '1234';

echo "<div style='font-family: sans-serif; padding: 20px;'>";
echo "<h1>Admin Password Reset</h1>";

// Generate the secure hash for the new password
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
echo "<p>Generated secure hash for password '<b>{$new_password}</b>'.</p>";

// Connect to the database
$database = new Database();
$conn = $database->getConnection();
echo "<p>Connected to the database.</p>";

// Prepare and execute the update
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->bind_param("ss", $hashed_password, $admin_email);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo "<h2 style='color: green;'>SUCCESS: The password for '{$admin_email}' has been updated.</h2>";
        echo "<p>You can now log in with this email and the password '<b>{$new_password}</b>'.</p>";
    } else {
        echo "<h2 style='color: orange;'>NOTICE: No user was found with the email '{$admin_email}'. Please make sure the email is correct in the database.</h2>";
    }
} else {
    echo "<h2 style='color: red;'>ERROR: The password could not be updated.</h2>";
    echo "<p>Error details: " . $stmt->error . "</p>";
}

echo "<p><b>Important:</b> Please delete this file (`public/fix_password.php`) after you log in successfully.</p>";
echo "</div>";