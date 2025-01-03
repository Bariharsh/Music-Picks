<?php
include('partials/_dbconnect.php');

// Handle Save Song (Add/Edit)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $song_id = $_POST['song_id'];
    $song_name = $_POST['song_name'];
    $artist_name = $_POST['artist_name'];
    $image_url = $_POST['image_url'];
    $song_url = $_POST['song_url'];

    if ($song_id){
        // Update existing song
        $query = "UPDATE songs SET title = '$song_name', artist = '$artist_name', album_art = '$image_url', song_file = '$song_url' WHERE song_id = '$song_id'";
    } else {
        // Add new song
        $query = "INSERT INTO songs (title, artist, album_art, song_file) VALUES ('$song_name', '$artist_name', '$image_url', '$song_url')";
    }

    if ($conn->query($query) === TRUE) {
        header("Location: admin.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle Delete Song
if (isset($_GET['delete_song'])) {
    $song_id = $_GET['delete_song'];

    $query = "DELETE FROM songs WHERE song_id = $song_id";

    if ($conn->query($query) === TRUE) {
        header("Location: admin.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
-