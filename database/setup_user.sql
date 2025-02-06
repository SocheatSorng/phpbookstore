-- Create database user with privileges
CREATE USER IF NOT EXISTS 'user'@'localhost' IDENTIFIED BY 'User@123';
GRANT ALL PRIVILEGES ON bookstore_db.* TO 'user'@'localhost';
FLUSH PRIVILEGES;
