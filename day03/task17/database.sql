CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    birth_date DATE
);



CREATE TABLE trainers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    specialization VARCHAR(100)
);



CREATE TABLE workouts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trainer_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    workout_date DATE NOT NULL,
    start_time TIME NOT NULL,
    duration INT NOT NULL,
    max_members INT NOT NULL,

    FOREIGN KEY (trainer_id) 
    REFERENCES trainers(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);



CREATE TABLE workout_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    workout_id INT NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE(member_id, workout_id),

    FOREIGN KEY (member_id) 
    REFERENCES members(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

    FOREIGN KEY (workout_id) 
    REFERENCES workouts(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);


CREATE TABLE membership_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    duration_days INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    visits_limit INT NOT NULL
);



CREATE TABLE memberships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    membership_plan_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    remaining_visits INT NOT NULL,
    status VARCHAR(20) DEFAULT 'active',

    FOREIGN KEY (member_id) 
    REFERENCES members(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

    FOREIGN KEY (membership_plan_id) 
    REFERENCES membership_plans(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);