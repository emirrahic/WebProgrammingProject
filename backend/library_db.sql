DROP DATABASE IF EXISTS library_db;
CREATE DATABASE library_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE library_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'member') NOT NULL DEFAULT 'member'
);

CREATE TABLE authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    country VARCHAR(100)
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(255)
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    isbn VARCHAR(20),
    copies INT NOT NULL DEFAULT 1,
    author_id INT NOT NULL,
    category_id INT NOT NULL,
    FOREIGN KEY (author_id) REFERENCES authors(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE loans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    loan_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE,
    status ENUM('borrowed', 'returned') NOT NULL DEFAULT 'borrowed',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
);

INSERT INTO users (id, name, email, password_hash, role) VALUES
(1, 'Admin User', 'admin@example.com', '$2y$10$tN0ZwIv6hlYMtK9NlWm0/.AjFPPx7BYHxkeb7nLQG59d0A.CiqPYC', 'admin'),
(2, 'Amar Hodzic', 'amar@example.com', '$2y$10$6cMgHcF0H.KtqqU0mymqiOaV5kdaVsYGLp.PqJWjlr1Wuk1LmSvUG', 'member'),
(3, 'Lejla Begic', 'lejla@example.com', '$2y$10$6cMgHcF0H.KtqqU0mymqiOaV5kdaVsYGLp.PqJWjlr1Wuk1LmSvUG', 'member'),
(4, 'Emir Kovac', 'emir@example.com', '$2y$10$6cMgHcF0H.KtqqU0mymqiOaV5kdaVsYGLp.PqJWjlr1Wuk1LmSvUG', 'member');

INSERT INTO authors (id, name, country) VALUES
(1, 'George Orwell', 'United Kingdom'),
(2, 'Stephen Hawking', 'United Kingdom'),
(3, 'Mesa Selimovic', 'Bosnia and Herzegovina'),
(4, 'Ivo Andric', 'Bosnia and Herzegovina'),
(5, 'Agatha Christie', 'United Kingdom');

INSERT INTO categories (id, name, description) VALUES
(1, 'Fiction', 'Made-up stories'),
(2, 'Science', 'Science and nature'),
(3, 'Novel', 'Long literary works'),
(4, 'Mystery', 'Crime and detective stories');

INSERT INTO books (id, title, isbn, copies, author_id, category_id) VALUES
(1, '1984', '9780451524935', 3, 1, 1),
(2, 'Animal Farm', '9780451526342', 2, 1, 1),
(3, 'A Brief History of Time', '9780553380163', 1, 2, 2),
(4, 'Death and the Dervish', '9788670000001', 4, 3, 3),
(5, 'The Bridge on the Drina', '9780226020457', 2, 4, 3),
(6, 'Murder on the Orient Express', '9780062693662', 3, 5, 4),
(7, 'The Universe in a Nutshell', '9780553802023', 1, 2, 2),
(8, 'And Then There Were None', '9780062073488', 2, 5, 4);

INSERT INTO loans (id, user_id, book_id, loan_date, due_date, return_date, status) VALUES
(1, 2, 1, '2026-10-01', '2026-10-15', NULL, 'borrowed'),
(2, 3, 2, '2026-09-20', '2026-10-04', '2026-10-02', 'returned'),
(3, 2, 6, '2026-10-10', '2026-10-24', NULL, 'borrowed'),
(4, 4, 3, '2026-09-05', '2026-09-19', '2026-09-18', 'returned'),
(5, 3, 4, '2026-10-15', '2026-10-29', NULL, 'borrowed'),
(6, 4, 5, '2026-10-18', '2026-11-01', NULL, 'borrowed');
