<?php
include("connection.php");
session_start();

if (empty($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}

$idcom = connexpdo("Smartshop");

if ($idcom) {
    $req = "SELECT * FROM users WHERE email = :email";
    $stmt = $idcom->prepare($req);
    $stmt->execute([":email" => $_SESSION['email']]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $password = "*******";
        $postalCode = $user['postalCode'];
        $address = $user['address'];
        $phone_number = $user['phone_number'];
        $country = $user['country'];
    } else {
        header("Location: index.php");
        exit;
    }
}
else
{
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $country = trim($_POST['country']);
    $address = trim($_POST['address']);
    $postalCode = trim($_POST['postalCode']);
    $phone_number = trim($_POST['phone_number']);

    try {
        $req = "UPDATE users
                SET country = :country,
                    address = :address,
                    postalCode = :postalCode,
                    phone_number = :phone_number
                WHERE email = :email";

        $stmt = $idcom->prepare($req);
        $stmt->execute([
            ':country' => $country,
            ":address" => $address,
            ":postalCode" => $postalCode,
            ":phone_number" => $phone_number,
            ":email" => $_SESSION['email']
        ]);
    } catch (Exception $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartShop - Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* 75% layout for navbar + content */
        .page-width {
            max-width: 75%;
            margin: auto;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container page-width">

        <!-- Logo -->
        <a class="navbar-brand" href="index.php">SmartShop</a>

        <!-- Mobile menu button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar content -->
        <div class="collapse navbar-collapse" id="navbarContent">

            <!-- Middle Links -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item mx-2"><a class="nav-link active" href="#">Accueil</a></li>
                <li class="nav-item mx-2"><a class="nav-link" href="#">Contact</a></li>
                <li class="nav-item mx-2"><a class="nav-link" href="#">Plan du site</a></li>
            </ul>

            <!-- Right -->
            <ul class="navbar-nav">
                <li class="nav-item mx-1"><a class="btn btn-outline-light" href="#">Profile</a></li>
                <li class="nav-item mx-1"><a class="btn btn-danger" href="logout.php">Logout</a></li>
            </ul>

        </div>
    </div>
</nav>

<!-- PAGE CONTENT -->
<div class="page-width mt-4">
    <h1 class="mb-3">Settings</h1>

    <form class="bg-light p-4 rounded shadow-sm" method="POST">

        <h3>Account Info</h3>
        <div class="mb-3">
            <label class="form-label">Email :</label>
            <input type="text" class="form-control" value="<?php echo $_SESSION['email'] ?>" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Password :</label>
            <input type="text" class="form-control" value="<?php echo $password ?>" disabled>
        </div>

        <h3 class="mt-4">Personal Info</h3>

        <div class="mb-3">
            <label class="form-label">Country :</label>
            <input type="text" name="country" class="form-control" value="<?php echo $country ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Address :</label>
            <input type="text" name="address" class="form-control" value="<?php echo $address ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Postal Code :</label>
            <input type="text" name="postalCode" class="form-control" value="<?php echo $postalCode ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone Number :</label>
            <input type="text" name="phone_number" class="form-control" value="<?php echo $phone_number ?>">
        </div>

        <button type="submit" class="btn btn-success mt-2">Save</button>
    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
