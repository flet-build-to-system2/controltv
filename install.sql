-- StreamVault Database Schema
-- Engine: InnoDB
-- Charset: utf8mb4
-- Collation: utf8mb4_unicode_ci

CREATE DATABASE IF NOT EXISTS streaming_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE streaming_db;

-- Admins table
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(200) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('super_admin','admin','editor') DEFAULT 'admin',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Categories table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type ENUM('general','movie','channel','anime') DEFAULT 'general',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Channels table
CREATE TABLE channels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    logo VARCHAR(500) DEFAULT NULL,
    m3u_link TEXT NOT NULL,
    category_id INT DEFAULT NULL,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Movies table
CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(300) NOT NULL,
    description TEXT DEFAULT NULL,
    release_year YEAR DEFAULT NULL,
    poster VARCHAR(500) DEFAULT NULL,
    video_url TEXT NOT NULL,
    category_id INT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Anime table
CREATE TABLE anime (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(300) NOT NULL,
    description TEXT DEFAULT NULL,
    release_year YEAR DEFAULT NULL,
    poster VARCHAR(500) DEFAULT NULL,
    category_id INT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Anime episodes table
CREATE TABLE anime_episodes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    anime_id INT NOT NULL,
    episode_number INT NOT NULL,
    title VARCHAR(300) DEFAULT NULL,
    video_url TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (anime_id) REFERENCES anime(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Ad settings table
CREATE TABLE ad_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    network_name VARCHAR(50) NOT NULL UNIQUE,
    settings_json JSON DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- App settings table
CREATE TABLE app_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed data for categories
INSERT INTO categories (name, type) VALUES
('Action', 'general'),
('Drama', 'general'),
('Comedy', 'general'),
('Sports', 'channel'),
('News', 'channel'),
('Sci-Fi', 'movie'),
('Shonen', 'anime'),
('Seinen', 'anime');

-- Seed data for app_settings
INSERT INTO app_settings (setting_key, setting_value) VALUES
('app_name', 'StreamVault'),
('app_version', '1.0.0'),
('app_description', 'Your ultimate streaming platform'),
('maintenance_mode', '0'),
('force_update', '0'),
('show_ads', '1'),
('enable_channels', '1'),
('enable_movies', '1'),
('enable_anime', '1');