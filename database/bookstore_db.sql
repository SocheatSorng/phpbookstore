-- Create database if not exists
CREATE DATABASE IF NOT EXISTS bookstore_db;
USE bookstore_db;

-- Users table
CREATE TABLE tbUsers (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Phone VARCHAR(15),
    Address TEXT,
    Role ENUM('admin', 'user') DEFAULT 'user',
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE tbCategories (
    CategoryID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(50) NOT NULL,
    Description TEXT,
    Image VARCHAR(255),
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Books table
CREATE TABLE tbBooks (
    BookID INT PRIMARY KEY AUTO_INCREMENT,
    CategoryID INT,
    Title VARCHAR(255) NOT NULL,
    Author VARCHAR(100) NOT NULL,
    ISBN VARCHAR(13) UNIQUE,
    Description TEXT,
    Price DECIMAL(10,2) NOT NULL,
    StockQuantity INT DEFAULT 0,
    Image VARCHAR(255),
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (CategoryID) REFERENCES tbCategories(CategoryID)
);

-- Orders table
CREATE TABLE tbOrders (
    OrderID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    OrderDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    TotalAmount DECIMAL(10,2) NOT NULL,
    Status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    ShippingAddress TEXT,
    PaymentMethod VARCHAR(50),
    FOREIGN KEY (UserID) REFERENCES tbUsers(UserID)
);

-- Order Details table
CREATE TABLE tbOrderDetails (
    OrderDetailID INT PRIMARY KEY AUTO_INCREMENT,
    OrderID INT,
    BookID INT,
    Quantity INT NOT NULL,
    Price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (OrderID) REFERENCES tbOrders(OrderID),
    FOREIGN KEY (BookID) REFERENCES tbBooks(BookID)
);

-- Shopping Cart table
CREATE TABLE tbCart (
    CartID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    BookID INT,
    Quantity INT NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES tbUsers(UserID),
    FOREIGN KEY (BookID) REFERENCES tbBooks(BookID)
);

-- Reviews table
CREATE TABLE tbReviews (
    ReviewID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    BookID INT,
    Rating INT NOT NULL CHECK (Rating >= 1 AND Rating <= 5),
    Comment TEXT,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES tbUsers(UserID),
    FOREIGN KEY (BookID) REFERENCES tbBooks(BookID)
);

-- Wishlist table
CREATE TABLE tbWishlist (
    WishlistID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    BookID INT,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES tbUsers(UserID),
    FOREIGN KEY (BookID) REFERENCES tbBooks(BookID)
);

-- Insert default admin user (password: admin123)
INSERT INTO tbUsers (FirstName, LastName, Email, Password, Role) 
VALUES ('Admin', 'User', 'admin@admin.com', '$2y$10$K.6HD4oEMHSW/xGSZKp4B.cWvxQOhD3o8QgHG1K0LWnM1svAQ88ey', 'admin');
