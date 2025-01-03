<?php
session_start();
include('partials/_dbconnect.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music App - My Album</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            /* background-color: black; */
            color: #fff;
            padding-top: 60px;
        }

        .navbar-brand {
            color: #fff;
        }

        .card {
            background-color: #444;
            border: none;
        }

        .card-title,
        .card-text {
            color: #fff;
        }

        .btn-outline-primary {
            color: #fff;
            border-color: #fff;
        }

        .btn-outline-primary:hover {
            background-color: #fff;
            color: #444;
        }

        .btn-outline-danger:hover {
            background-color: #fff;
            color: #444;
        }

        .progress {
            height: 5px;
            background-color: #555;
        }

        .progress-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #ff6f61, #d76ef5, #7c59f0);
            border-radius: 20px;
            transition: width 0.2s ease-in-out;
        }
    </style>
</head>

<body class="bg-dark">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-transparent">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Music Picks</a>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex">
                    <input class="form-control me-2" id="search-input" type="text" placeholder="Search Songs..." aria-label="Search">
                </div>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-success text-white " href="Logout.php">Logout</a>
                    </li>
                </ul>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <h1 class="mb-4">My Album</h1>

        <!-- Remove All Button -->
        <div class="mb-4">
            <form method="POST" action="removeall.php" onsubmit="return confirm('Are you sure you want to remove all songs from your album?');">
                <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i> Remove All</button>
            </form>
        </div>

        <div class="row" id="songcontainer">
            <?php
            $query = "SELECT * FROM user_stars WHERE user_id = '$user_id'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $song_id = $row['song_id'];

                    // Fetch song details
                    $song_query = "SELECT * FROM songs WHERE song_id = '$song_id'";
                    $song_result = mysqli_query($conn, $song_query);
                    $song = mysqli_fetch_assoc($song_result);

                    echo '<div class="col-md-6 col-lg-4 mb-4 display">';
                    echo '<div class="card h-100">';
                    echo '<img src="' . $song['album_art'] . '" class="card-img-top" alt="' . $song['title'] . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $song['title'] . '</h5>';
                    echo '<p class="card-text">Artist: ' . $song['artist'] . '</p>';
                    echo '<button class="btn btn-outline-primary me-2 play-btn" data-song-url="' . $song['song_file'] . '">';
                    echo '<i class="bi bi-play-circle"></i>';
                    echo '</button>';
                    echo '<a href="delete_album.php?song_id=' . $song_id . '" class="btn btn-outline-danger" onclick="return confirm(\'Are you sure you want to remove this song from your album?\')">';
                    echo '<i class="bi bi-trash"></i> Remove';
                    echo '</a>';
                    echo '<div class="progress mt-3">';
                    echo '<div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No songs in your album.</p>';
            }

            $conn->close();
            ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- Custom JS -->
    <script src="javascript/myalbum.js"></script>
</body>

</html>