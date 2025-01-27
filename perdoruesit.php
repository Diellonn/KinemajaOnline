<?php
session_start();
require_once('User.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Nuk keni akses në këtë faqe.");
}

$userManager = new User();
$users = $userManager->getAllUsers();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    $message = $userManager->deleteUser($user_id);

    $users = $userManager->getAllUsers();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista e Përdoruesve</title>
    <link rel="stylesheet" href="styleadmin.css">
</head>
<body>
    <header>
        <h1>Lista e Përdoruesve</h1>
        <div class="nav-menu">
            <a href="manage.php">Kthehu te Menaxhimi i Filmit</a>
        </div>
        <div class="loginform">
            <a href="logout.php" class="logout-link">Logout</a>
        </div>
    </header>

    <main>
        <div class="content-wrapper">
            <div class="movie-list">
                <h2>Përdoruesit</h2>
                
                <?php if (isset($message)): ?>
                    <p><?php echo $message; ?></p>
                <?php endif; ?>

                <?php if (count($users) == 0): ?>
                    <p>Nuk ka përdorues për të shfaqur.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Emri</th>
                                <th>Email</th>
                                <th>Roli</th>
                                <th>Veprim</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['emri'] . ' ' . $user['mbiemri']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['roli']); ?></td>
                                    <td>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" name="delete_user">Fshi</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>
