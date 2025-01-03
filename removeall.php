<?php
session_start();
include('partials/_dbconnect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Prepare and execute the SQL statement to delete all songs from the user's album
$query = "DELETE FROM user_stars WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);

if ($stmt->execute()) {
    // Redirect back to the My Album page with a success message
    $_SESSION['message'] = "All songs removed from your album.";
} else {
    // Redirect back to the My Album page with an error message
    $_SESSION['error'] = "Failed to remove all songs. Please try again.";
}

$stmt->close();
$conn->close();
header('Location: myalbum.php');
exit();
?>
