<?php
    session_start();
    require_once 'Database.php';
    $db = new Database();

    $genre = isset($_GET['genre']) ? $_GET['genre'] : '';
    $query = "SELECT * FROM movies" . ($genre ? " WHERE genre = :genre" : '');
    $stmt = $db->conn->prepare($query);

    if ($genre) {
            $stmt->bindParam(':genre', $genre);
    }
    $stmt->execute();
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KinemajaOnline</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <img src="image/logo.png" alt="">
    <div class="nav-menu"> 
        <a href="#" id="homeLink">Ballina</a>
        <div class="dropdown">
            <a href="#">Zhanri</a>
            <div class="dropdown-content">
                <a href="?genre=Aksion">Aksion</a>
                <a href="?genre=Dramë">Dramë</a>
                <a href="?genre=Thriller">Thriller</a>
                <a href="?genre=Romance">Romance</a>
                <a href="?genre=Komedi">Komedi</a>
                <a href="?genre=Sport">Sport</a>
            </div>
        </div>
        <script src="script.js"></script>
        <a href="seriale.html">Seriale</a>
        <a href="Kontakti.php">Kontakti</a>
    </div>
    <div class="search">
        <input type="search" placeholder="Kerko">
    </div>
    <?php if (isset($_SESSION['user_name'])): ?>
        <div class="loginform">
            <span class="loginform"> <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="manage.php">Edito</a>
            <?php endif; ?>
            <a href="logout.php">Logout</a>
        </div>
    <?php else: ?>
        <div class="loginform">
        <a href="login.php">Login</a>
        </div>
    <?php endif; ?>
</header>
<section class="movies">
    <h2>Filmat e Fundit</h2>
    <div class="movie-grid">
            <?php foreach ($movies as $movie): ?>
                <div class="movie">
                <img src="<?php echo $movie['image']; ?>" alt="Filmi" width="100">
                    <h3><?= htmlspecialchars($movie['title']); ?></h3>
                    <p>Zhanri: <?= htmlspecialchars($movie['genre']); ?></p>
                    <p><a style="text-decoration:wavy;color:white;" href="movies.php?id=<?php echo $movie['id']; ?>">Shiko</a></p>
                </div>
            <?php endforeach; ?>
                <div class="movie">
                    <img src="filmat/hacker.jpg" alt="Filmi 4">
                    <h3>Hacker</h3>
                    <p>Zhanri: Thriller-Crime</p>
                </div>
                <div class="movie">
                    <img src="filmat/absolution.jpg" alt="Filmi 4">
                    <h3>Absolution</h3>
                    <p>Zhanri: Mister</p>
                </div>
                <div class="movie">
                    <img src="filmat/thelittlething.jpg" alt="Filmi 4">
                    <h3>The Little Thing</h3>
                    <p>Zhanri: Crime</p>
                </div>
                <div class="movie">
                    <img src="filmat/rockybalboa.jpg" alt="Filmi 4">
                    <h3>Rocky Balboa</h3>
                    <p>Zhanri: Sport-Aksion</p>
                </div>
                <div class="movie">
                    <img src="filmat/mrmrssmith,jpg.jpg" alt="Filmi 4">
                    <h3>Mr.& Mrs.Smith</h3>
                    <p>Zhanri: Aksion-Komedi</p>
                </div>
                <div class="movie">
                    <img src="filmat/titanic.jpg" alt="Filmi 4">
                    <h3>Titanic</h3>
                    <p>Zhanri: Romance-Adventure</p>
                </div>
                <div class="movie">
                    <img src="filmat/fastfurious.jpg" alt="Filmi 4">
                    <h3>Fast & Furious</h3>
                    <p>Zhanri: Aksion-Crime</p>
                </div>
    </div>
</section>

</body>
</html>