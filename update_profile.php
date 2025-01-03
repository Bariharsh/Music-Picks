<?php
session_start();
include('partials/_dbconnect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get user inputs
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare SQL query to update user details
if (!empty($password)) {
    // Hash the new password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $query = "UPDATE user SET username = ?, email = ?, password = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssi', $username, $email, $hashed_password, $user_id);
} else {
    $query = "UPDATE user SET username = ?, email = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssi', $username, $email, $user_id);
}

// Execute the query
if ($stmt->execute()) {
    // Profile updated successfully
    $_SESSION['message'] = "Profile updated successfully!";
    header("Location: profile.php");
    exit;
} else {
    // Handle error
    $_SESSION['error'] = "Error updating profile.";
    header("Location: profile.php");
    exit;
}

$stmt->close();
$conn->close();
?>
