-- Create database
CREATE DATABASE IF NOT EXISTS event_management 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE event_management;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Events table
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    date DATE NOT NULL,
    time TIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    category VARCHAR(100) DEFAULT 'مؤتمر',
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);

-- Speakers table
CREATE TABLE IF NOT EXISTS speakers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    bio TEXT,
    expertise VARCHAR(255),
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Event-Speakers relationship table
CREATE TABLE IF NOT EXISTS event_speakers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    speaker_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (speaker_id) REFERENCES speakers(id) ON DELETE CASCADE,
    UNIQUE KEY unique_event_speaker (event_id, speaker_id)
);

-- Attendees table
CREATE TABLE IF NOT EXISTS attendees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- Indexes for better performance
CREATE INDEX idx_events_date ON events(date);
CREATE INDEX idx_events_created_by ON events(created_by);
CREATE INDEX idx_events_category ON events(category);
CREATE INDEX idx_attendees_event_id ON attendees(event_id);
CREATE INDEX idx_attendees_email ON attendees(email);
CREATE INDEX idx_event_speakers_event_id ON event_speakers(event_id);
CREATE INDEX idx_event_speakers_speaker_id ON event_speakers(speaker_id);
CREATE INDEX idx_speakers_email ON speakers(email);
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_username ON users(username);

-- Insert default admin user
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('user1', 'user1@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('user2', 'user2@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- Show table structure verification
SELECT 
    TABLE_NAME, 
    TABLE_ROWS, 
    DATA_LENGTH, 
    INDEX_LENGTH,
    CREATE_TIME,
    UPDATE_TIME
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'event_management';