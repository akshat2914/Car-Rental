CREATE TABLE IF NOT EXISTS vendors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    owner_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    car_model VARCHAR(100) NOT NULL,
    car_registration_number VARCHAR(20) NOT NULL UNIQUE,
    city VARCHAR(100) NOT NULL,
    car_photo VARCHAR(255)
);

