DELIMITER //

-- User Management Procedures
CREATE PROCEDURE sp_GetUser(IN p_UserID INT)
BEGIN
    SELECT * FROM tbUser WHERE UserID = p_UserID;
END //

CREATE PROCEDURE sp_GetUserByEmail(IN p_Email VARCHAR(100))
BEGIN 
    SELECT * FROM tbUser WHERE Email = p_Email;
END //

CREATE PROCEDURE sp_InsertUser(
    IN p_FirstName VARCHAR(50),
    IN p_LastName VARCHAR(50),
    IN p_Email VARCHAR(100),
    IN p_Password VARCHAR(255),
    IN p_Phone VARCHAR(15),
    IN p_Address TEXT
)
BEGIN
    INSERT INTO tbUser(FirstName, LastName, Email, Password, Phone, Address)
    VALUES(p_FirstName, p_LastName, p_Email, p_Password, p_Phone, p_Address);
    SELECT LAST_INSERT_ID() AS UserID;
END //

CREATE PROCEDURE sp_UpdateUser(
    IN p_UserID INT,
    IN p_FirstName VARCHAR(50),
    IN p_LastName VARCHAR(50),
    IN p_Phone VARCHAR(15),
    IN p_Address TEXT
)
BEGIN
    UPDATE tbUser 
    SET FirstName = p_FirstName,
        LastName = p_LastName,
        Phone = p_Phone,
        Address = p_Address
    WHERE UserID = p_UserID;
END //

-- Book Management Procedures
CREATE PROCEDURE sp_GetAllBooks(
    IN p_Page INT,
    IN p_Limit INT
)
BEGIN
    DECLARE p_Offset INT;
    SET p_Offset = (p_Page - 1) * p_Limit;
    
    SELECT b.*, c.Name as CategoryName
    FROM tbBook b
    LEFT JOIN tbCategory c ON b.CategoryID = c.CategoryID
    LIMIT p_Limit OFFSET p_Offset;
END //

CREATE PROCEDURE sp_GetBooksByCategory(
    IN p_CategoryID INT,
    IN p_Page INT,
    IN p_Limit INT
)
BEGIN
    DECLARE p_Offset INT;
    SET p_Offset = (p_Page - 1) * p_Limit;
    
    SELECT b.*, c.Name as CategoryName
    FROM tbBook b
    LEFT JOIN tbCategory c ON b.CategoryID = c.CategoryID
    WHERE b.CategoryID = p_CategoryID
    LIMIT p_Limit OFFSET p_Offset;
END //

CREATE PROCEDURE sp_InsertBook(
    IN p_CategoryID INT,
    IN p_Title VARCHAR(255),
    IN p_Author VARCHAR(100),
    IN p_ISBN VARCHAR(13),
    IN p_Description TEXT,
    IN p_Price DECIMAL(10,2),
    IN p_StockQuantity INT,
    IN p_Image VARCHAR(255)
)
BEGIN
    INSERT INTO tbBook(CategoryID, Title, Author, ISBN, Description, Price, StockQuantity, Image)
    VALUES(p_CategoryID, p_Title, p_Author, p_ISBN, p_Description, p_Price, p_StockQuantity, p_Image);
    SELECT LAST_INSERT_ID() AS BookID;
END //

CREATE PROCEDURE sp_UpdateBook(
    IN p_BookID INT,
    IN p_CategoryID INT,
    IN p_Title VARCHAR(255),
    IN p_Author VARCHAR(100),
    IN p_Description TEXT,
    IN p_Price DECIMAL(10,2),
    IN p_StockQuantity INT,
    IN p_Image VARCHAR(255)
)
BEGIN
    UPDATE tbBook 
    SET CategoryID = p_CategoryID,
        Title = p_Title,
        Author = p_Author,
        Description = p_Description,
        Price = p_Price,
        StockQuantity = p_StockQuantity,
        Image = COALESCE(p_Image, Image)
    WHERE BookID = p_BookID;
END //

-- Order Management Procedures
CREATE PROCEDURE sp_CreateOrder(
    IN p_UserID INT,
    IN p_TotalAmount DECIMAL(10,2),
    IN p_ShippingAddress TEXT,
    IN p_PaymentMethod VARCHAR(50)
)
BEGIN
    INSERT INTO tbOrder(UserID, TotalAmount, ShippingAddress, PaymentMethod)
    VALUES(p_UserID, p_TotalAmount, p_ShippingAddress, p_PaymentMethod);
    SELECT LAST_INSERT_ID() AS OrderID;
END //

CREATE PROCEDURE sp_AddOrderDetail(
    IN p_OrderID INT,
    IN p_BookID INT,
    IN p_Quantity INT,
    IN p_Price DECIMAL(10,2)
)
BEGIN
    INSERT INTO tbOrderDetail(OrderID, BookID, Quantity, Price)
    VALUES(p_OrderID, p_BookID, p_Quantity, p_Price);
    
    -- Update stock quantity
    UPDATE tbBook 
    SET StockQuantity = StockQuantity - p_Quantity
    WHERE BookID = p_BookID;
END //

CREATE PROCEDURE sp_GetUserOrders(IN p_UserID INT)
BEGIN
    SELECT o.*, 
           od.BookID,
           b.Title as BookTitle,
           od.Quantity,
           od.Price as UnitPrice
    FROM tbOrder o
    JOIN tbOrderDetail od ON o.OrderID = od.OrderID
    JOIN tbBook b ON od.BookID = b.BookID
    WHERE o.UserID = p_UserID
    ORDER BY o.OrderDate DESC;
END //

-- Cart Management Procedures
CREATE PROCEDURE sp_AddToCart(
    IN p_UserID INT,
    IN p_BookID INT,
    IN p_Quantity INT
)
BEGIN
    INSERT INTO tbCart(UserID, BookID, Quantity)
    VALUES(p_UserID, p_BookID, p_Quantity)
    ON DUPLICATE KEY UPDATE Quantity = Quantity + p_Quantity;
END //

CREATE PROCEDURE sp_UpdateCartQuantity(
    IN p_CartID INT,
    IN p_Quantity INT
)
BEGIN
    UPDATE tbCart SET Quantity = p_Quantity WHERE CartID = p_CartID;
END //

CREATE PROCEDURE sp_GetUserCart(IN p_UserID INT)
BEGIN
    SELECT c.*, 
           b.Title,
           b.Price,
           b.Image,
           (b.Price * c.Quantity) as TotalPrice
    FROM tbCart c
    JOIN tbBook b ON c.BookID = b.BookID
    WHERE c.UserID = p_UserID;
END //

-- Review Management Procedures
CREATE PROCEDURE sp_AddReview(
    IN p_UserID INT,
    IN p_BookID INT,
    IN p_Rating INT,
    IN p_Comment TEXT
)
BEGIN
    INSERT INTO tbReview(UserID, BookID, Rating, Comment)
    VALUES(p_UserID, p_BookID, p_Rating, p_Comment);
END //

CREATE PROCEDURE sp_GetBookReviews(IN p_BookID INT)
BEGIN
    SELECT r.*,
           u.FirstName,
           u.LastName
    FROM tbReview r
    JOIN tbUser u ON r.UserID = u.UserID
    WHERE r.BookID = p_BookID
    ORDER BY r.CreatedAt DESC;
END //

-- Wishlist Management Procedures
CREATE PROCEDURE sp_AddToWishlist(
    IN p_UserID INT,
    IN p_BookID INT
)
BEGIN
    INSERT IGNORE INTO tbWishlist(UserID, BookID)
    VALUES(p_UserID, p_BookID);
END //

CREATE PROCEDURE sp_RemoveFromWishlist(
    IN p_UserID INT,
    IN p_BookID INT
)
BEGIN
    DELETE FROM tbWishlist 
    WHERE UserID = p_UserID AND BookID = p_BookID;
END //

CREATE PROCEDURE sp_GetUserWishlist(IN p_UserID INT)
BEGIN
    SELECT w.*,
           b.Title,
           b.Author,
           b.Price,
           b.Image
    FROM tbWishlist w
    JOIN tbBook b ON w.BookID = b.BookID
    WHERE w.UserID = p_UserID
    ORDER BY w.CreatedAt DESC;
END //

DELIMITER ;
