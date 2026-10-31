-- OMAHCODE Database Schema
-- Compatible with SQLite and MySQL / MariaDB

CREATE TABLE IF NOT EXISTS settings (
    `key` VARCHAR(100) PRIMARY KEY,
    `value` TEXT,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admins (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100),
    `role` VARCHAR(20) DEFAULT 'admin',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `name` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(150),
    `category` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `features` TEXT,
    `target_users` VARCHAR(255),
    `demo_url` VARCHAR(255),
    `cta_text` VARCHAR(50) DEFAULT 'Demo Aplikasi',
    `image` VARCHAR(255),
    `sort_order` INTEGER DEFAULT 0,
    `is_active` INTEGER DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS services (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `title` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(150),
    `category` VARCHAR(100),
    `short_desc` TEXT,
    `full_desc` TEXT,
    `icon` VARCHAR(100) DEFAULT 'fa-solid fa-laptop-code',
    `image` VARCHAR(255),
    `sort_order` INTEGER DEFAULT 0,
    `is_active` INTEGER DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS portfolio (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `title` VARCHAR(150) NOT NULL,
    `category` VARCHAR(100) NOT NULL,
    `client_name` VARCHAR(150),
    `description` TEXT,
    `tech_stack` VARCHAR(255),
    `project_url` VARCHAR(255),
    `image` VARCHAR(255),
    `sort_order` INTEGER DEFAULT 0,
    `is_active` INTEGER DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS messages (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(50),
    `subject` VARCHAR(150),
    `message` TEXT NOT NULL,
    `status` VARCHAR(20) DEFAULT 'new',
    `ip_address` VARCHAR(50),
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

