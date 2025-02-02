<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include 'Database.php';

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    $db = new Database();
    $conn = $db->conn;

    $query = "INSERT INTO contacts (name, email, subject, message) VALUES (:name, :email, :subject, :message)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':subject', $subject);
    $stmt->bindParam(':message', $message);

    if ($stmt->execute()) {
        $successMessage = "Mesazhi u dërgua me sukses!";
    } else {
        $errorMessage = "Gabim gjatë dërgimit të mesazhit.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KinemajaOnline - Kontakti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <a href="#"><img src="image/logo.png" alt="Logo"></a>
        <div class="nav-menu">
            <a href="KinemajaOnline.php">Ballina</a>
            <a href="#">Zhanri</a>
            <a href="seriale.php">Seriale</a>
            <a href="#">Kontakti</a>
        </div>
        <div class="search">
            <input type="search" placeholder="Kerko">
        </div>
        <?php if (isset($_SESSION['user_name'])): ?>
        <div class="loginform">
            <span class="loginform" style="color: white;"> <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="manage.php" class="admin-button">Edito</a>
            <?php endif; ?>
            <a href="logout.php" class="logout-link">Logout</a>
        </div>
    <?php else: ?>
        <div class="loginform">
            <a href="login.php">Login</a>
        </div>
    <?php endif; ?>
    </header>
    <section class="home">
        <div class="wrapper">
            <h2>Na Kontaktoni</h2>
            <?php if (!empty($successMessage)): ?>
                <p class="success"><?php echo htmlspecialchars($successMessage); ?></p>
            <?php elseif (!empty($errorMessage)): ?>
                <p class="error"><?php echo htmlspecialchars($errorMessage); ?></p>
            <?php endif; ?>

            <form method="POST">
                <div class="input-row">
                    <div class="input-field">
                        <input type="text" id="name" name="name" placeholder=" " required>
                        <label for="name">Emri juaj</label>
                    </div>
                    <div class="input-field">
                        <input type="email" id="email" name="email" placeholder=" " required>
                        <label for="email">Email-i juaj</label>
                    </div>
                </div>
                <div class="input-field">
                    <input type="text" id="subject" name="subject" placeholder=" " required>
                    <label for="subject">Subjekti</label>
                </div>
                <div class="input-field">
                    <textarea id="message" name="message" rows="5" placeholder=" " required></textarea>
                    <label for="message">Mesazhi juaj</label>
                </div>
                <button type="submit">Dërgo</button>
            </form>
        </div>
    </section>
</body>
</html>
