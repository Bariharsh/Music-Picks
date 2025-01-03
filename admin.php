<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Music App</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #2c2c2c;
            color: #fff;
            padding-top: 60px;
        }
        .navbar {
            background-color: #1c1c1c;
        }
        .navbar-brand {
            color: #fff;
        }
        .table {
            background-color: #444;
        }
        .table th, .table td {
            color: #fff;
        }
        .form-control {
            background-color: #444;
            color: #fff;
            border: 1px solid #555;
        }
        .btn-primary {
            background-color: #1c1c1c;
            border-color: #444;
        }
        .btn-primary:hover {
            background-color: #444;
            border-color: #1c1c1c;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="mb-4">Manage Songs</h1>

    <!-- Add/Edit Song Form -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Add New Song</h5>
            <form action="
             " method="POST">
                <input type="hidden" name="song_id" id="song_id">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="song_name" class="form-label">Song Name</label>
                        <input type="text" class="form-control" id="song_name" name="song_name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="artist_name" class="form-label">Artist Name</label>
                        <input type="text" class="form-control" id="artist_name" name="artist_name" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="image_url" class="form-label">Image URL</label>
                        <input type="text" class="form-control" id="image_url" name="image_url" required>
                    </div>
                    <div class="col-md-6">
                        <label for="song_url" class="form-label">Song URL</label>
                        <input type="text" class="form-control" id="song_url" name="song_url" required>
                    </div>
                </div>
                <button type="submit"  class="btn btn-primary">Save Song</button>
            </form>
        </div>
    </div>

    <!-- Songs Table -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Existing Songs</h5>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Song Name</th>
                        <th>Artist Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('partials/_dbconnect.php');

                    $query = "SELECT * FROM songs";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td><img src="' . $row['album_art'] . '" width="50" height="50" ></td>';
                            echo '<td>' . $row['title'] . '</td>';
                            echo '<td>' . $row['artist'] . '</td>';
                            echo '<td>';
                            echo '<button class="btn btn-outline-warning me-2 edit-btn" data-song-id="' . $row['song_id'] . '" data-song-name="' . $row['title'] . '" data-artist-name="' . $row['artist'] . '" data-image-url="' . $row['album_art'] . '" data-song-url="' . $row['song_file'] . '"><i class="bi bi-pencil"></i></button>';
                            echo '<a href="admin_process.php?delete_song=' . $row['song_id'] . '" class="btn btn-outline-danger" onclick="return confirm(\'Are you sure you want to delete this song?\')"><i class="bi bi-trash"></i></a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4">No songs found.</td></tr>';
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('partials/footer2.php'); ?>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<!-- Custom JS -->
<script src="javascript/admin.js"></script>
</body>
</html>
