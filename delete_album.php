<?php
session_start();
include('partials/_dbconnect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['song_id'])) {
    $song_id = $_GET['song_id'];

    // Prepare and execute the SQL statement to delete the song from the user's album
    $query = "DELETE FROM user_stars WHERE user_id = ? AND song_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $user_id, $song_id);

    if ($stmt->execute()) {
        // Redirect back to the My Album page with a success message
        $_SESSION['message'] = "Song removed from your album.";
    } else {
        // Redirect back to the My Album page with an error message
        $_SESSION['error'] = "Failed to remove the song. Please try again.";
    }

    $stmt->close();
} else {
    // Redirect back to the My Album page if no song_id is provided
    $_SESSION['error'] = "Invalid request.";
}

$conn->close();
header('Location: myalbum.php');
exit();
?>
