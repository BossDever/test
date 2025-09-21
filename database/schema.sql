-- MySQL 8+ schema for Survey System
-- Ensure default charset is utf8mb4 and collation utf8mb4_general_ci

CREATE TABLE IF NOT EXISTS roles (
  id TINYINT PRIMARY KEY,
  name VARCHAR(32) UNIQUE
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO roles (id,name) VALUES
(1,'admin'),(2,'teacher'),(3,'committee'),(4,'expert')
ON DUPLICATE KEY UPDATE name=VALUES(name);

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(64) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role_id TINYINT NOT NULL,
  display_name VARCHAR(128),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (role_id) REFERENCES roles(id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS surveys (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  is_active TINYINT(1) DEFAULT 1,
  created_by INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (created_by) REFERENCES users(id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS sections (
  id INT AUTO_INCREMENT PRIMARY KEY,
  survey_id INT NOT NULL,
  code VARCHAR(10) NOT NULL,
  title VARCHAR(255) NOT NULL,
  sort_order INT DEFAULT 0,
  FOREIGN KEY (survey_id) REFERENCES surveys(id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS questions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  survey_id INT NOT NULL,
  section_id INT NOT NULL,
  item_code VARCHAR(20) NOT NULL,     -- e.g., "3.2(5)"
  q_text TEXT NOT NULL,
  q_type ENUM('likert','text','bool') DEFAULT 'likert',
  is_required TINYINT(1) DEFAULT 1,
  has_detail TINYINT(1) DEFAULT 0,
  sort_order INT DEFAULT 0,
  FOREIGN KEY (survey_id) REFERENCES surveys(id),
  FOREIGN KEY (section_id) REFERENCES sections(id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS responses (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  survey_id INT NOT NULL,
  respondent_type ENUM('expert','teacher','committee','student','other') DEFAULT 'expert',
  respondent_other VARCHAR(255),
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (survey_id) REFERENCES surveys(id),
  INDEX (survey_id, submitted_at)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS answers (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  response_id BIGINT NOT NULL,
  question_id INT NOT NULL,
  value_likert TINYINT NULL,     -- 1-5
  value_text TEXT NULL,
  value_bool TINYINT(1) NULL,
  FOREIGN KEY (response_id) REFERENCES responses(id),
  FOREIGN KEY (question_id) REFERENCES questions(id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS audit_logs (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  action VARCHAR(64),
  details TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Optional table: used when end users submit free-text suggestions
CREATE TABLE IF NOT EXISTS suggestions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  survey_id INT NOT NULL,
  response_id INT NOT NULL,
  respondent_type VARCHAR(50) NULL,
  suggestion TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX (survey_id), INDEX (response_id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
