DROP DATABASE IF EXISTS event_system;

CREATE DATABASE event_system;

USE event_system;



CREATE TABLE users (

    id INT AUTO_INCREMENT PRIMARY KEY,

    username VARCHAR(100) NOT NULL,

    email VARCHAR(150) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    role ENUM('user','admin') DEFAULT 'user',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);




-- email: admin@gmail.com
-- password: admin123

INSERT INTO users 
(username, email, password, role)
VALUES
(
    'admin',
    'admin@gmail.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llZx7uL5h9z8j9Wz6Qf5K',
    'admin'
);



-- email: user@gmail.com
-- password: user123

INSERT INTO users 
(username, email, password, role)
VALUES
(
    'user',
    'user@gmail.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llZx7uL5h9z8j9Wz6Qf5K',
    'user'
);


CREATE TABLE categories (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL UNIQUE

);

INSERT INTO categories (name) VALUES

('Концерт'),
('Спорт'),
('Театър'),
('Конференция');


CREATE TABLE events (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(150) NOT NULL,

    description TEXT,

    category_id INT NOT NULL,

    start_date DATETIME NOT NULL,

    end_date DATETIME NOT NULL,

    location VARCHAR(255) NOT NULL,

    image VARCHAR(255),

    status ENUM(
        'Предстоящо',
        'Провежда се',
        'Приключило'
    ) DEFAULT 'Предстоящо',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,


    FOREIGN KEY (category_id)
    REFERENCES categories(id)

);


CREATE TABLE ticket_types (

    id INT AUTO_INCREMENT PRIMARY KEY,

    event_id INT NOT NULL,

    name VARCHAR(100) NOT NULL,

    price DECIMAL(10,2) NOT NULL,

    quantity INT NOT NULL,


    FOREIGN KEY (event_id)
    REFERENCES events(id)
    ON DELETE CASCADE

);


CREATE TABLE orders (

    id INT AUTO_INCREMENT PRIMARY KEY,

    order_number VARCHAR(50) NOT NULL UNIQUE,

    user_id INT NOT NULL,

    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    total_price DECIMAL(10,2) NOT NULL,

    status ENUM(
        'Нова',
        'Платена',
        'Отказана',
        'Завършена'
    ) DEFAULT 'Нова',


    FOREIGN KEY (user_id)
    REFERENCES users(id)

);


CREATE TABLE tickets (

    id INT AUTO_INCREMENT PRIMARY KEY,

    order_id INT NOT NULL,

    ticket_type_id INT NOT NULL,

    ticket_code VARCHAR(50) NOT NULL UNIQUE,

    is_used BOOLEAN DEFAULT FALSE,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,


    FOREIGN KEY (order_id)
    REFERENCES orders(id)
    ON DELETE CASCADE,


    FOREIGN KEY (ticket_type_id)
    REFERENCES ticket_types(id)

);



ALTER TABLE events

ADD INDEX idx_event_name(name),

ADD INDEX idx_event_date(start_date),

ADD INDEX idx_event_category(category_id),

ADD INDEX idx_event_status(status);


ALTER TABLE ticket_types

ADD INDEX idx_ticket_event(event_id),

ADD INDEX idx_ticket_price(price);


ALTER TABLE tickets

ADD INDEX idx_ticket_code(ticket_code),

ADD INDEX idx_ticket_order(order_id);



ALTER TABLE orders

ADD INDEX idx_order_user(user_id),

ADD INDEX idx_order_status(status);