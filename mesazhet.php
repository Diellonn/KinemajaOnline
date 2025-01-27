<?php
session_start();
include 'Database.php';
include 'User.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Nuk keni akses në këtë faqe.");
}
$db = new Database();
$conn = $db->conn;

$user = new User($conn);

$contactMessages = $user->getAllMessages();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_message'])) {
    $message_id = $_POST['message_id'];

    if ($user->deleteMessage($message_id)) {
        $message = "Mesazhi u fshi me sukses!";
    } else {
        $message = "Gabim gjatë fshirjes së mesazhit.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesazhet e Klientëve</title>
    <link rel="stylesheet" href="styleadmin.css">
</head>
<body>
    <header>
        <h1>Mesazhet e Klientëve</h1>
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
                <h2>Mesazhet nga Kontaktet</h2>
                
                <?php if (isset($message)): ?>
                    <p><?php echo $message; ?></p>
                <?php endif; ?>

                <?php if (count($contactMessages) == 0): ?>
                    <p>Nuk ka mesazhe për të shfaqur.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Emri</th>
                                <th>Email</th>
                                <th>Subjekti</th>
                                <th>Mesazhi</th>
                                <th>Veprim</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contactMessages as $contact): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($contact['id']); ?></td>
                                    <td><?php echo htmlspecialchars($contact['name']); ?></td>
                                    <td><?php echo htmlspecialchars($contact['email']); ?></td>
                                    <td><?php echo htmlspecialchars($contact['subject']); ?></td>
                                    <td><?php echo htmlspecialchars($contact['message']); ?></td>
                                    <td>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="message_id" value="<?php echo $contact['id']; ?>">
                                            <button type="submit" name="delete_message">Fshi</button>
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