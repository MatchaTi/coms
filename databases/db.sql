CREATE DATABASE commit;

use commit;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    fullname VARCHAR(255),
    bio VARCHAR(255) DEFAULT 'Hai selamat datang',
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    photo VARCHAR(255) DEFAULT 'img/profiles/profile.jpg',
    role enum('user','admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    category_id INT,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    photo VARCHAR(255),
    watching_counter INT DEFAULT 0,
    share_counter INT DEFAULT 0,
    isSolve bool default false,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON update cascade,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE ON update cascade
);

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    post_id INT,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON update cascade,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE ON update cascade
);