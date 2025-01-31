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
    <style>
    @media (max-width: 768px) {
        .nav-menu {
            flex-direction: column;
            align-items: center;
        }
        .nav-menu a {
            margin: 10px 0;
            font-size: 16px;
        }
        .search input {
            width: 100%;
            margin-top: 10px;
        }
        .loginform {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }
        .movie-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 5px;
        }
        .movie {
            width: 25%;
            margin-bottom: 15px;

        }
        .movie img{
            size: 10px;
        }
        .movie h3{
        font-size: 11px;  
        }
        .movie p{
            font-size: 11px;  
        }
    }
    @media (max-width: 480px) {
        header {
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .nav-menu {
            margin-top: 10px;
        }
        .search input {
            width: 100%;
            margin-top: 15px;
        }
        .movie-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: space-between;
        }
        .movie {
            width: 23%;
        }
    }
    </style>
</head>
<body>
<header>
    <img src="image/logo.png" alt="Logo">
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
        <a href="seriale.php">Seriale</a>
        <a href="Kontakti.php">Kontakti</a>

    </div>
    <div class="search">
        <input type="search" placeholder="Kerko">
    </div>
    <?php if (isset($_SESSION['user_name'])): ?>
        <div class="loginform">
            <span class="loginform" style="color: white;"> <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
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
    </div>
</section>

</body>
</html>