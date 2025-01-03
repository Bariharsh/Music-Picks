<?php
session_start();
include('partials/_dbconnect.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$song_id = $_POST['song_id'];

// Check if the song is already starred by the user
$check_query = "SELECT * FROM user_stars WHERE user_id = '$user_id' AND song_id = '$song_id'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) == 0) {
    // If not already starred, insert into user_stars
    $insert_query = "INSERT INTO user_stars (user_id, song_id) VALUES ('$user_id', '$song_id')";
    mysqli_query($conn, $insert_query);
} else {
    // If already starred, remove it from user_stars
    $delete_query = "DELETE FROM user_stars WHERE user_id = '$user_id' AND song_id = '$song_id'";
    mysqli_query($conn, $delete_query);
}

// Redirect back to the previous page (or wherever you want)
header("Location: home.php");
exit();
?>
