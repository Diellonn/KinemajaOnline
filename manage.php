<?php
session_start();
include 'database.php';
include 'Movie.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Nuk keni akses në këtë faqe.");
}
$db = new Database();
$conn = $db->conn;
$movie = new Movie($conn);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_movie'])) {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $genre = isset($_POST['genre']) ? $_POST['genre'] : '';
    $youtube_link = isset($_POST['youtube_link']) ? $_POST['youtube_link'] : '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['image']['type'], $allowedTypes)) {
            if (move_uploaded_file($imageTmpName, $imagePath)) {
                if ($movie->addMovie($title, $genre, $imagePath, $youtube_link)) {
                    $message = "Filmi u shtua me sukses!";
                } else {
                    $message = "Gabim gjatë shtimit të filmit.";
                }
            } else {
                $message = "Gabim gjatë ngarkimit të imazhit.";
            }
        } else {
            $message = "Lloji i imazhit nuk është i lejuar.";
        }
    } else {
        $message = "Ju lutem ngarkoni një imazh.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_movie'])) {
    $movie_id = $_POST['movie_id'];

    if ($movie->deleteMovie($movie_id)) {
        $message = "Filmi u fshi me sukses!";
    } else {
        $message = "Gabim gjatë fshirjes së filmit.";
    }
}

$movies = $movie->getAllMovies();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administratori</title>
    <link rel="stylesheet" href="styleadmin.css">
</head>
<body>
<header>
    <h1>Admin-<?php echo htmlspecialchars($_SESSION['user_name']);?></h1>
    <div class="nav-menu">
        <a href="KinemajaOnline.php" class="home-link">Kthehu te Ballina</a>
    </div>
    <div class="loginform">
        <a href="logout.php" class="logout-link">Logout</a>
    </div>
</header>
<main>
    <div class="content-wrapper">
        <div class="add-movie">
            <h2>Shto një Film</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="title">Titulli:</label>
                <input type="text" id="title" name="title" required>

                <label for="genre">Zhanri:</label>
                <input type="text" id="genre" name="genre" required>

                <label for="youtube_link">Linku i YouTube:</label>
                <input type="text" id="youtube_link" name="youtube_link" required>

                <label for="image">Ngarko Imazhin:</label>
                <input type="file" id="image" name="image" required>

                <button type="submit" name="add_movie">Shto Filmin</button>
            </form>

        </div>
        <div class="movie-list">
            <h2 style="color: white;">Lista e Filmit</h2>
            <?php if (isset($message)): ?>
                <p style="color: white;"><?php echo $message; ?></p>
            <?php endif; ?>

            <?php if (count($movies) == 0): ?>
                <p style="color: white;">Nuk ka filma për të shfaqur.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Emri</th>
                            <th>Zhanri</th>
                            <th>Imazhi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movies as $movie): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($movie['id']); ?></td>
                                <td><?php echo htmlspecialchars($movie['title']); ?></td>
                                <td><?php echo htmlspecialchars($movie['genre']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($movie['image']); ?>" alt="Filmi" width="100"></td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">
                                        <button type="submit" name="delete_movie">Fshi</button>
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