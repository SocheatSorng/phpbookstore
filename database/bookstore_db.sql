-- Create database if not exists
CREATE DATABASE IF NOT EXISTS bookstore_db;
USE bookstore_db;

-- Users table
CREATE TABLE tbUser (
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
CREATE TABLE tbCategory (
    CategoryID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(50) NOT NULL,
    Description TEXT,
    Image VARCHAR(255),
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Books table
CREATE TABLE tbBook (
    BookID INT PRIMARY KEY AUTO_INCREMENT,
    CategoryID INT,
    Title VARCHAR(255) NOT NULL,
    Author VARCHAR(100) NOT NULL,
    Price DECIMAL(10,2) NOT NULL,
    StockQuantity INT DEFAULT 0,
    Image VARCHAR(255),  -- Cover Image
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (CategoryID) REFERENCES tbCategory(CategoryID)
);


-- Book Details table for attributes
CREATE TABLE tbBookDetail (
    DetailID INT PRIMARY KEY AUTO_INCREMENT,
    BookID INT UNIQUE,  
    ISBN10 VARCHAR(10),  
    ISBN13 VARCHAR(17),  
    Publisher VARCHAR(255),  
    PublishYear INT,  
    Edition VARCHAR(50),  
    PageCount INT,  
    Language VARCHAR(50),  
    Format ENUM('Hardcover', 'Paperback', 'Ebook', 'Audiobook'),  
    Dimensions VARCHAR(100),  
    Weight DECIMAL(6,2),  
    Description TEXT,  
    FOREIGN KEY (BookID) REFERENCES tbBook(BookID) ON DELETE CASCADE
);

-- Orders table
CREATE TABLE tbOrder (
    OrderID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    OrderDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    TotalAmount DECIMAL(10,2) NOT NULL,
    Status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    ShippingAddress TEXT,
    PaymentMethod VARCHAR(50),
    FOREIGN KEY (UserID) REFERENCES tbUser(UserID)
);

-- Order Details table
CREATE TABLE tbOrderDetail (
    OrderDetailID INT PRIMARY KEY AUTO_INCREMENT,
    OrderID INT,
    BookID INT,
    Quantity INT NOT NULL,
    Price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (OrderID) REFERENCES tbOrder(OrderID),
    FOREIGN KEY (BookID) REFERENCES tbBook(BookID)
);

-- Shopping Cart table
CREATE TABLE tbCart (
    CartID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    BookID INT,
    Quantity INT NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES tbUser(UserID),
    FOREIGN KEY (BookID) REFERENCES tbBook(BookID)
);

-- Reviews table
CREATE TABLE tbReview (
    ReviewID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    BookID INT,
    Rating INT NOT NULL CHECK (Rating >= 1 AND Rating <= 5),
    Comment TEXT,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES tbUser(UserID),
    FOREIGN KEY (BookID) REFERENCES tbBook(BookID)
);

-- Wishlist table
CREATE TABLE tbWishlist (
    WishlistID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    BookID INT,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES tbUser(UserID),
    FOREIGN KEY (BookID) REFERENCES tbBook(BookID)
);

-- Purchase Table
CREATE TABLE tbPurchase (
    PurchaseID INT PRIMARY KEY,
    BookID INT NOT NULL,
    Quantity INT NOT NULL,
    UnitPrice DECIMAL(10,2) NOT NULL,
    PaymentMethod VARCHAR(50) NOT NULL,
    OrderDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (BookID) REFERENCES tbBook(BookID)
);

-- Settings table
CREATE TABLE tbSettings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    meta_title VARCHAR(255),
    meta_keywords TEXT,
    theme VARCHAR(50),
    layout VARCHAR(50),
    description TEXT,
    store_name VARCHAR(255),
    owner_name VARCHAR(255),
    owner_phone VARCHAR(50),
    owner_email VARCHAR(255),
    store_address TEXT,
    zipcode VARCHAR(20),
    city VARCHAR(100),
    country VARCHAR(100),
    currency VARCHAR(50),
    language VARCHAR(50),
    tax_rate DECIMAL(5,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default settings
INSERT INTO tbSettings (id, meta_title, store_name) VALUES (1, 'PHP Bookstore', 'PHP Bookstore');

-- Insert default admin user (password: admin123)
INSERT INTO tbUser (FirstName, LastName, Email, Password, Role) 
VALUES ('Admin', 'User', 'admin@admin.com', '$2y$10$XiQ5PlWiAmMo6MTEuxz/Ze4VGI3pv4OC9dQ5t0tbIxsO5g8oN7IDm', 'admin');

