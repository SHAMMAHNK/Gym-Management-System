-- SQL script to create the 'gym' database and 'users' table for XAMPP MySQL

USE gym;

-- Create the users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    date_of_birth DATE NOT NULL,
    membership_type VARCHAR(20) NOT NULL,
    referral_code VARCHAR(20),
    fitness_goal VARCHAR(50),
    workout_times VARCHAR(100), 
    experience_level VARCHAR(20),
    medical_conditions TEXT,
    emergency_contact_name VARCHAR(100) NOT NULL,
    emergency_relationship VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL, -- Hashed password
    newsletter_subscribed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert a sample user for testing
-- Password is 'password123' hashed with PASSWORD_DEFAULT
INSERT INTO users (
    first_name, last_name, email, phone, date_of_birth, membership_type,
    emergency_contact_name, emergency_relationship, password
) VALUES (
    'John', 'Doe', 'john.doe@example.com', '123-456-7890', '1990-01-01', 'basic',
    'Jane Doe', 'spouse', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
);
