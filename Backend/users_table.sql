USE car_rental_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15),
    passsword VARCHAR(255) NOT NULL,
    age INT NOT NULL,
    driving_license VARCHAR(255) NOT NULL,
    photo VARCHAR(255),
    aadhar_number VARCHAR(12) NOT NULL UNIQUE
);

