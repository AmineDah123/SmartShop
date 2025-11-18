<?php
include("connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sign_up']))
{
    if (!empty($_POST['email']) && !empty($_POST['password']))
    {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $idcom = connexpdo('Smartshop');
        if ($idcom)
        {
            try{
                $req = "SELECT email,password FROM users WHERE (email = :email)";
                $stmt = $idcom->prepare($req);
                $stmt->execute([
                    ':email' => $email
                ]);

                if ($stmt->rowCount() > 0)
                {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (password_verify($password, $row['password']))
                    {
                        $_SESSION['email'] = $email;
                        header("Location: index.php");
                        exit;
                    }

                    header("Location: index.php");
                    exit;
                }
            }
            catch (PDOException $e)
            {
                $_SESSION['error'] = "There is no such user! How about trying to sign up?";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;

            }
        }
        else
        {
            $_SESSION['error'] = "Fatal Error In Database! Contact Support Immediately!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
        
    }


}

$errorMessage = '';
if (isset($_SESSION['error'])) {
    $errorMessage = $_SESSION['error'];
    unset($_SESSION['error']); 
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartShop - Login</title>

    <!-- BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card shadow-lg p-4" style="width: 380px; border-radius: 15px;">
            
            <h3 class="text-center mb-4">Login</h3>

            <?php if ($errorMessage): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password"  required>
                </div>

                <button type="submit" class="btn btn-primary w-100" name="sign_up" >Login</button>

                <p class="text-center mt-3">
                    Not Signed Up?
                    <a href="SignUp.php" class="fw-bold">Click Here!</a>
                </p>
            </form>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
