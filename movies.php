<?php
session_start();
include 'database.php';
include 'Movie.php';

$db = new Database();
$conn = $db->conn;

$movie = new Movie($conn);

$movies = $movie->getAllMovies();

if ($movies === false) {
    echo "Gabim gjatë ngarkimit të të dhënave nga baza e të dhënave.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmat</title>
    <link rel="stylesheet" href="style.css">
    <style>
    .movie-list {
        margin-top: 1.5%;
        margin-left: 10%;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 40px;
        width: 100%;
        max-width: 1200px;
    }
    .movie-container {
        text-align: center;
        background-color: #000;
        border-radius: 10px;
        overflow: hidden;
        width: 80%;
        max-width: 860px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .movie-iframe {
        width: 100%;
        height: auto;
        max-width: 100%;
        aspect-ratio: 16 / 9;
        border: none;
        position: relative;
    }
    .movie-info {
        padding: 20px;
        background-color: rgba(0, 0, 0, 0.8);
        color: #fff;
        border-radius: 0 0 10px 10px;
    }
    .movie-title {
        font-size: 26px;
        font-weight: bold;
        margin: 10px 0;
    }
    .movie-genre {
        font-size: 18px;
        color: #ccc;
    }
    </style>
</head>
<body>
<header>
        <a href="#"><img src="image/logo.png" alt="Logo"></a>
        <div class="nav-menu">
            <a href="KinemajaOnline.php">Ballina</a>
            <a href="#">Zhanri</a>
            <a href="seriale.html">Seriale</a>
            <a href="#">Kontakti</a>
        </div>
        <div class="search">
            <input type="search" placeholder="Kerko">
        </div>
        <?php if (isset($_SESSION['user_name'])): ?>
        <div class="loginform">
            <span class="loginform"> <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
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
    <div class="movie-list">
        <?php foreach ($movies as $movie): ?>
            <div class="movie-container">
                <?php if (!empty($movie['youtube_link'])): ?>
                    <iframe class="movie-iframe" src="<?php echo htmlspecialchars($movie['youtube_link']); ?>" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <?php endif; ?>

                <div class="movie-info">
                    <div class="movie-title"><?php echo htmlspecialchars($movie['title']); ?></div>
                    <div class="movie-genre"><?php echo htmlspecialchars($movie['genre']); ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>