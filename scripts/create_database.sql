CREATE DATABASE IF NOT EXISTS task_management;

USE task_management;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    priority ENUM('baja', 'media', 'alta') NOT NULL,
    status ENUM('pendiente', 'completada') NOT NULL DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS user_tasks (
    user_id INT,
    task_id INT,
    PRIMARY KEY (user_id, task_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE
);

INSERT INTO users (name, email, password) VALUES ('user1', 'user1@test.com', '12345678');
INSERT INTO users (name, email, password) VALUES ('user2', 'user2@test.com', '12345678');
INSERT INTO users (name, email, password) VALUES ('user3', 'user3@test.com', '12345678');
INSERT INTO users (name, email, password) VALUES ('user4', 'user4@test.com', '12345678');
INSERT INTO users (name, email, password) VALUES ('user5', 'user5@test.com', '12345678');