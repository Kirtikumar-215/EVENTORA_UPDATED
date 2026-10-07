CREATE DATABASE IF NOT EXISTS eventora CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE eventora;

CREATE TABLE users (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 role ENUM('student','host','coordinator','volunteer','admin') NOT NULL DEFAULT 'student',
 status ENUM('active','inactive') NOT NULL DEFAULT 'active',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE event_requests (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id INT UNSIGNED NOT NULL,
 title VARCHAR(180) NOT NULL,
 category VARCHAR(80) NOT NULL,
 description TEXT NOT NULL,
 event_date DATETIME NOT NULL,
 venue VARCHAR(180) NOT NULL,
 expected_participants INT NOT NULL DEFAULT 0,
 budget DECIMAL(12,2) NOT NULL DEFAULT 0,
 requirements TEXT,
 status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
 reviewed_at DATETIME NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE events (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 host_id INT UNSIGNED NULL,
 title VARCHAR(180) NOT NULL,
 category VARCHAR(80) NOT NULL,
 description TEXT NOT NULL,
 event_date DATETIME NOT NULL,
 venue VARCHAR(180) NOT NULL,
 expected_participants INT NOT NULL DEFAULT 0,
 budget DECIMAL(12,2) NOT NULL DEFAULT 0,
 requirements TEXT,
 status ENUM('draft','approved','closed','completed') NOT NULL DEFAULT 'draft',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(host_id) REFERENCES users(id) ON DELETE SET NULL,
 INDEX(event_date,status)
) ENGINE=InnoDB;

CREATE TABLE registrations (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id INT UNSIGNED NOT NULL,
 event_id INT UNSIGNED NOT NULL,
 status ENUM('confirmed','cancelled') NOT NULL DEFAULT 'confirmed',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY unique_registration(user_id,event_id),
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
 FOREIGN KEY(event_id) REFERENCES events(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE volunteer_applications (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id INT UNSIGNED NOT NULL,
 event_id INT UNSIGNED NOT NULL,
 position VARCHAR(120) NOT NULL,
 note TEXT,
 status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
 reviewed_at DATETIME NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY unique_volunteer(user_id,event_id),
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
 FOREIGN KEY(event_id) REFERENCES events(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE coordinator_applications (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id INT UNSIGNED NOT NULL,
 event_id INT UNSIGNED NOT NULL,
 note TEXT,
 status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
 reviewed_at DATETIME NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY unique_coordinator(user_id,event_id),
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
 FOREIGN KEY(event_id) REFERENCES events(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE notifications (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id INT UNSIGNED NOT NULL,
 title VARCHAR(180) NOT NULL,
 message TEXT NOT NULL,
 is_read TINYINT(1) NOT NULL DEFAULT 0,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE attendance (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 event_id INT UNSIGNED NOT NULL,
 user_id INT UNSIGNED NOT NULL,
 attended TINYINT(1) NOT NULL DEFAULT 0,
 marked_at DATETIME NULL,
 UNIQUE KEY unique_attendance(event_id,user_id),
 FOREIGN KEY(event_id) REFERENCES events(id) ON DELETE CASCADE,
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE certificates (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 event_id INT UNSIGNED NOT NULL,
 user_id INT UNSIGNED NOT NULL,
 certificate_type ENUM('participation','volunteer','coordinator','winner') NOT NULL DEFAULT 'participation',
 certificate_code VARCHAR(80) NOT NULL UNIQUE,
 issued_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(event_id) REFERENCES events(id) ON DELETE CASCADE,
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO users(name,email,password,role,status) VALUES
('Eventora HOD','hod@eventora.local','$2y$12$rKtqbDABEraycuPIOiPCrOifMDbmy3Q.ReSADyzaW3f1yQ5VaZtR2','admin','active'),
('Kirtikumar Prajapati','student@eventora.local','$2y$12$rKtqbDABEraycuPIOiPCrOifMDbmy3Q.ReSADyzaW3f1yQ5VaZtR2','student','active');

INSERT INTO events(host_id,title,category,description,event_date,venue,expected_participants,budget,requirements,status) VALUES
(2,'TechFest 2026','Technology','A flagship technology festival with hackathons, coding battles, AI showcases and creator challenges.','2026-10-18 10:00:00','Main Auditorium',300,25000,'10 volunteers, 3 coordinators, projector','approved'),
(2,'Campus Cultural Night','Cultural','Music, dance, fashion and the biggest student showcase of the semester.','2026-10-25 18:30:00','Open Air Theatre',500,40000,'20 volunteers, stage team','approved'),
(2,'Design Sprint','Workshop','A hands-on product design sprint for future builders and storytellers.','2026-11-02 11:00:00','Innovation Lab',100,10000,'6 volunteers, projector','approved');
