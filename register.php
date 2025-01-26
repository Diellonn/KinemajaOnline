<?php
require_once 'User.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emri = $_POST['firstname'];
    $mbiemri = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = new User();
    $message = $user->register($emri, $mbiemri, $email, $password);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KinemajaOnline - Regjistrohu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>  
        <img src="image/logo.png" alt="Logo">
        <div class="nav-menu">
            <a href="KinemajaOnline.html">Ballina</a>
        </div>
    </header>
    <section class="home">
        <div class="wrapper">
            <form action="register.php" method="post">
                <h2>Regjistrohu</h2>
                <div class="input-row">
                    <div class="input-field">
                        <input type="text" id="emri" name="firstname" placeholder="Emri" required>
                    </div>
                    <div class="input-field">
                        <input type="text" id="mbiemri" name="lastname" placeholder="Mbiemri" required>
                    </div>
                </div>
                <div class="input-field">
                    <input type="email" id="adresaEmail" name="email" placeholder="Shtyp email-in" required>
                </div>
                <div class="input-field">
                    <input type="password" id="pass" name="password" placeholder="Shtyp password-in" required>
                </div>
                <div class="input-field">
                    <input type="password" id="konfirmoPass" name="password" placeholder="Rishtyp password-in" required>
                </div>
                <button type="submit" id="registerBtn">Regjistrohu</button>
                <p>Keni ndonje llogari <a href="login.php">Login</a></p>
            </form>
            <?php if (isset($message)) : ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>
