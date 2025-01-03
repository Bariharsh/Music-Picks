<?php
session_start();
include('partials/_dbconnect.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Fetch all songs
$songs_query = "SELECT * FROM songs";
$songs_result = mysqli_query($conn, $songs_query);

// Fetch all starred songs for the logged-in user
$starred_query = "SELECT song_id FROM user_stars WHERE user_id = '$user_id'";
$starred_result = mysqli_query($conn, $starred_query);

$starred_songs = [];

while ($row = mysqli_fetch_assoc($starred_result)) {
    $starred_songs[] = $row['song_id'];
}

$user = "SELECT * FROM users";
$userresult = mysqli_query($conn, $user);

// Fetch user details
$user_query = "SELECT username FROM users WHERE user_id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);

if ($user_result && mysqli_num_rows($user_result) > 0) {
    $user = mysqli_fetch_assoc($user_result);
    $username = $user['username'];
} else {
    $username = 'User'; // Fallback if the username is not found
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Picks - Welcome <?php echo $username; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="partials/style.css">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script src="javascript/jquery-3.7.1.min.js"></script>
    <!-- Custom CSS -->
</head>

<body class="bg-dark">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-transparent">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Music Picks</a>

            <!-- <div class="container w-50 h-25 justify-center">
                <div id="alert-message" class="alert alert-success alert-dismissible fade h-25" role="alert" style="display: none;">
                    <strong>Success!</strong> Your song has been saved to your album.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                </div>
            </div> -->

            <div class="collapse navbar-collapse justify-content-end " id="navbarNav">
                <div class="d-flex">
                    <input class="form-control me-2" id="search-input" type="text" placeholder="Search Song Here..." aria-label="Search">
                </div>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-success text-white " href="myalbum.php">My Album</a>
                    </li>
                    &nbsp;
                    <li class="nav-item">
                        <a class="nav-link btn btn-success text-white" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>



    <!-- Main Content -->
    <div class="container" id="songcontainer">
        <div class="row">
            <?php
            if ($songs_result->num_rows > 0) {
                while ($song = mysqli_fetch_assoc($songs_result)) {
                    $song_id = $song['song_id'];
                    $is_starred = in_array($song_id, $starred_songs); // Check if the song is starred by the user
                    $star_icon = $is_starred ? 'bi-star-fill' : 'bi-star';
                    echo '<div class="col-md-6 col-lg-4 mb-4 display">';
                    echo '<div class="card h-100">';
                    echo '<img src="' . $song['album_art'] . '" class="card-img-top" alt="' . $song['title'] . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $song['title'] . '</h5>';
                    echo '<p class="card-text">Artist: ' . $song['artist'] . '</p>';
                    echo '<button class="btn btn-outline-primary me-2 play-btn" data-song-url="' . $song['song_file'] . '">';
                    echo '<i class="bi bi-play-circle"></i>';
                    echo '</button>';
                    echo '<button class="btn btn-outline-secondary star-btn" data-song-id="' . $song_id . '" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-custom-class="custom-tooltip"
                    data-bs-title="Click this button for Adding to your Album">';
                    echo '<i class="bi ' . $star_icon . ' starred"></i>';
                    echo '</button>';
                    echo '<div class="progress mt-3 style="cursor: pointer;">';
                    echo '<div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';  
                    echo '</div>';
                }
            } else {
                echo '<p>No songs available.</p>';
            }
            ?>
        </div>
    </div>

    <!-- footer  -->
    <?php include('partials/footer2.php'); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="javascript/play.js"></script>
</body>

</html>