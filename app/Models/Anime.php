<?php
require_once __DIR__ . '/../config/database.php';

class Anime {
    public static function getAll() {
        $pdo = Database::getConnection();
        $anime = $pdo->query("SELECT a.*, cat.name as category_name FROM anime a LEFT JOIN categories cat ON a.category_id = cat.id ORDER BY a.created_at DESC")->fetchAll();
        foreach ($anime as &$a) {
            $a['episodes'] = self::getEpisodes($a['id']);
        }
        return $anime;
    }

    public static function getById($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT a.*, cat.name as category_name FROM anime a LEFT JOIN categories cat ON a.category_id = cat.id WHERE a.id = ?");
        $stmt->execute([$id]);
        $anime = $stmt->fetch();
        if ($anime) {
            $anime['episodes'] = self::getEpisodes($id);
        }
        return $anime;
    }

    public static function create($title, $description, $release_year, $poster, $category_id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO anime (title, description, release_year, poster, category_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $release_year ?: null, $poster, $category_id ?: null]);
        return $pdo->lastInsertId();
    }

    public static function update($id, $title, $description, $release_year, $poster, $category_id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE anime SET title = ?, description = ?, release_year = ?, poster = ?, category_id = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $release_year ?: null, $poster, $category_id ?: null, $id]);
    }

    public static function delete($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM anime WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function count() {
        $pdo = Database::getConnection();
        return $pdo->query("SELECT COUNT(*) FROM anime")->fetchColumn();
    }

    public static function getEpisodes($anime_id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM anime_episodes WHERE anime_id = ? ORDER BY episode_number ASC");
        $stmt->execute([$anime_id]);
        return $stmt->fetchAll();
    }

    public static function addEpisode($anime_id, $episode_number, $title, $video_url) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO anime_episodes (anime_id, episode_number, title, video_url) VALUES (?, ?, ?, ?)");
        $stmt->execute([$anime_id, $episode_number, $title, $video_url]);
        return $pdo->lastInsertId();
    }

    public static function deleteEpisode($episode_id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM anime_episodes WHERE id = ?");
        return $stmt->execute([$episode_id]);
    }
}
?>