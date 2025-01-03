<?php
include('_dbconnect.php');


$admin_username = 'Harsh Bari';
$admin_email = 'harshbari227@gmail.com';
$admin_password = '1234';

$hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);


$query = "INSERT INTO users (username, email,password, role) VALUES (?, ?, ?,'admin')";
$stmt = $conn->prepare($query);
$stmt->bind_param('sss', $admin_username,$admin_email, $hashed_password);

if ($stmt->execute()) {
    echo "Admin user created successfully!";
} else {
    echo "Failed to create admin user. Please try again.";
}
?>





