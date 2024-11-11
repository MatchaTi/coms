CREATE DATABASE coms;

USE COMS;

CREATE TABLE users (
	nim VARCHAR(10) NOT NULL PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    fullname VARCHAR(255),
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    ktm VARCHAR(255) NOT NULL,
    photo VARCHAR(255),
    role ENUM("admin","user") NOT NULL DEFAULT "USER",
    joined_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    bio VARCHAR(255),
    link_instagram VARCHAR(255),
    link_facebook VARCHAR(255),
    link_github VARCHAR(255),
    link_linkedin VARCHAR(255),
    isPrivate TINYINT(1) DEFAULT 0,
    status TINYINT(1) DEFAULT 0
);

CREATE TABLE categories(
	id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE posts(
	id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    photo VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    counter_views INT DEFAULT 0,
    user_nim VARCHAR(10) NOT NULL,
    category_id INT DEFAULT 1,
    FOREIGN KEY (user_nim) REFERENCES users(nim) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE comments(
	id INT AUTO_INCREMENT PRIMARY KEY,
    content VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_nim VARCHAR(10) NOT NULL,
    post_id INT NOT NULL,
    FOREIGN KEY (user_nim) REFERENCES users(nim) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO users(nim, username, email, password, ktm) VALUES ("2309106065", "Adi", "adi@gmail.com", "adi", "ktm.jpg");
SELECT * FROM users;

INSERT INTO categories(name) VALUES ("front-end"), ("back-end"), ("full-stack");
SELECT * FROM categories;

INSERT INTO posts(title, user_nim, category_id) VALUES("Cinta Mati Tailwind", "2309106065", 1);
SELECT * FROM posts;

INSERT INTO comments(content, user_nim, post_id) VALUES("Tailwind mantap!", "2309106065", 1);
SELECT * FROM comments;

delete from users where nim = "2309106065";