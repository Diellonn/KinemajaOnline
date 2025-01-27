<?php
class Movie {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function addMovie($title, $genre, $imagePath, $youtube_link) {
        $query = "INSERT INTO movies (title, genre, image, youtube_link) VALUES (:title, :genre, :image, :youtube_link)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':image', $imagePath);
        $stmt->bindParam(':youtube_link', $youtube_link);
    
        return $stmt->execute();
    }
    public function deleteMovie($movie_id) {
        $query = "DELETE FROM movies WHERE id = :movie_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function getAllMovies() {
        $query = "SELECT * FROM movies";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getYouTubeLink($movie_id) {
        $query = "SELECT youtube_link FROM movies WHERE id = :movie_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['youtube_link'] : null;
    }
}
?>