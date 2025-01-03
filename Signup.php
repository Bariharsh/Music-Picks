<?php
session_start();
include('partials/_dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    

    // Check if the passwords match
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Check if the email already exists
        $check_query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Email is already registered.";
        } else {
            // Insert new user into the database
            $insert_query = "INSERT INTO users (username, email, password,role) VALUES (?, ?, ?,'user')";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param('sss', $username, $email, $hashed_password);
            $stmt->execute();

            // Automatically log the user in after signup
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['username'] = $username;

            header('Location: home.php');
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music App - Sign Up</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            /* background-color: #2c2c2c; */
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
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
<body class="bg-dark">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center mb-4">Sign Up</h4>
                    <form action="signup.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                    </form>
                </div>
            </div>
            <p class="text-center mt-3">Already have an account? <a href="login.php" class="text-white">Login</a></p>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>

