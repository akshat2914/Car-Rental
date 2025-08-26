USE car_rental_db;

CREATE TABLE IF NOT EXISTS cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vendor_id INT NOT NULL,
    car_name VARCHAR(100) NOT NULL,
    fuel_type VARCHAR(50) NOT NULL,
    mileage FLOAT NOT NULL,
    seats INT NOT NULL,
    driving_type ENUM('manual', 'automatic') NOT NULL,
    price INT NOT NULL,
    car_image VARCHAR(255),
    FOREIGN KEY (vendor_id) REFERENCES vendors(id) ON DELETE CASCADE
);

