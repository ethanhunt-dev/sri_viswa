-- Import in phpMyAdmin or: mysql -u root -p < sql/schema.sql
CREATE DATABASE IF NOT EXISTS srinivasa_site
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE srinivasa_site;

CREATE TABLE IF NOT EXISTS contact_submissions (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  designation VARCHAR(255) NOT NULL,
  company VARCHAR(255) NOT NULL,
  country VARCHAR(100) DEFAULT NULL,
  email VARCHAR(255) NOT NULL,
  mobile VARCHAR(64) DEFAULT NULL,
  product VARCHAR(255) NOT NULL,
  quantity VARCHAR(128) NOT NULL,
  remarks TEXT,
  ip_address VARCHAR(45) DEFAULT NULL,
  user_agent VARCHAR(512) DEFAULT NULL,
  geo_city VARCHAR(128) DEFAULT NULL,
  geo_state VARCHAR(128) DEFAULT NULL,
  geo_country VARCHAR(128) DEFAULT NULL,
  utm_source VARCHAR(128) DEFAULT NULL,
  utm_campaign VARCHAR(128) DEFAULT NULL,
  utm_medium VARCHAR(128) DEFAULT NULL,
  utm_term VARCHAR(256) DEFAULT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
