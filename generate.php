<?php
// Password to hash
$password = "procurement@portal"; // Replace with the password you want to hash

// Hash the password using PASSWORD_BCRYPT
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Output the hashed password
echo "Hashed Password: " . $hashedPassword;
?>
