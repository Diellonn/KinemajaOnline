<?php
session_start();
require_once('User.php');
$email = $password = "";
$errorMessage = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = new User();
    $userData = $user->login($email, $password);

    if (is_array($userData)) {
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['user_name'] = $userData['emri'] . ' ' . $userData['mbiemri'];
        $_SESSION['role'] = $userData['roli'];

        header("Location: KinemajaOnline.php");
        exit();
    } else {
        $errorMessage = $userData; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KinemajaOnline - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <img src="image/logo.png" alt="">
    <div class="nav-menu">
        <a href="KinemajaOnline.php">Ballina</a>
    </div>
</header>

<section class="home">
    <div class="wrapper">
        <form action="login.php" method="post">
            <h2>Login</h2>

            <div class="input-field">
                <input type="email" name="email" placeholder="Shtyp email-in" value="<?php echo $email; ?>" required>
            </div>

            <div class="input-field">
                <input type="password" name="password" placeholder="Shtyp password-in" required>
            </div>

            <button type="submit" id="loginBtn">Login</button>
            <p>Ende nuk keni një llogari? <a href="register.php">Regjistrohu tani!</a></p>
            <?php if ($errorMessage): ?>
                <p><?php echo htmlspecialchars($errorMessage); ?></p>
            <?php endif; ?>
        </form>
    </div>
</section>

</body>
</html>
