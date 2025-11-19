<?php
include("connection.php");
session_start();

$isLoggedIn = isset($_SESSION['email']);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartShop - Index</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Optional: makes the navbar exactly ~75% width on large screens */
        .navbar-container {
            max-width: 75%;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container navbar-container">

        <!-- Left: Logo -->
        <a class="navbar-brand" href="#">SmartShop</a>

        <!-- Burger (mobile) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Middle + Right -->
        <div class="collapse navbar-collapse" id="navbarContent">

            <!-- Middle -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item mx-2"><a class="nav-link active" href="#">Acceuil</a></li>
                <li class="nav-item mx-2"><a class="nav-link" href="#">Contact</a></li>
                <li class="nav-item mx-2"><a class="nav-link" href="#">Plan du site</a></li>
            </ul>

            <!-- Right -->
           <?php if ($isLoggedIn): ?>
            <ul class="navbar-nav">
                <li class="nav-item mx-1">
                    <a class="btn btn-outline-light" href="profile.php">Profile</a>
                </li>
                <li class="nav-item mx-1">
                    <a class="btn btn-danger" href="logout.php">Logout</a>
                </li>
            </ul>
            <?php else: ?>
                <ul class="navbar-nav">
                    <li class="nav-item mx-1">
                        <a class="btn btn-outline-light" href="Login.php">Login</a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="btn btn-primary" href="SignUp.php">SignUp</a>
                    </li>
                </ul>
            <?php endif; ?>


        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
