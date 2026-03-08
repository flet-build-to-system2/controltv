<?php
require_once __DIR__ . '/../config/database.php';

class AnimeController {
    public static function index() {
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

    public static function store($title, $description, $release_year, $category_id, $poster = null) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO anime (title, description, release_year, poster, category_id) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$title, $description, $release_year ?: null, $poster, $category_id ?: null]);
    }

    public static function update($id, $title, $description, $release_year, $category_id, $poster = null) {
        $pdo = Database::getConnection();
        if ($poster !== null) {
            $stmt = $pdo->prepare("UPDATE anime SET title = ?, description = ?, release_year = ?, poster = ?, category_id = ? WHERE id = ?");
            return $stmt->execute([$title, $description, $release_year ?: null, $poster, $category_id ?: null, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE anime SET title = ?, description = ?, release_year = ?, category_id = ? WHERE id = ?");
            return $stmt->execute([$title, $description, $release_year ?: null, $category_id ?: null, $id]);
        }
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
        return $stmt->execute([$anime_id, $episode_number, $title, $video_url]);
    }

    public static function deleteEpisode($episode_id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM anime_episodes WHERE id = ?");
        return $stmt->execute([$episode_id]);
    }

    public static function uploadPoster($file) {
        $uploadDir = __DIR__ . '/../../public/uploads/anime/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'ani_' . time() . '_' . uniqid() . '.' . $ext;
        $path = $uploadDir . $filename;
        if (move_uploaded_file($file['tmp_name'], $path)) {
            return 'uploads/anime/' . $filename;
        }
        return null;
    }
}
?>