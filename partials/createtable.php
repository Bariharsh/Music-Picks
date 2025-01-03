<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "music_picks";

$conn = mysqli_connect($servername,$username,$password,$database);

$sql = "CREATE TABLE user_stars (
    star_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    song_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (song_id) REFERENCES songs(song_id))";

$result = mysqli_query($conn,$sql);

if($result){
    echo "Table created Succesfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
?>