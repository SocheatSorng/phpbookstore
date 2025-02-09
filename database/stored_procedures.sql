DELIMITER //

-- User Management Procedures
DROP PROCEDURE IF EXISTS sp_InsertUser //

CREATE PROCEDURE sp_InsertUser(
    IN p_FirstName VARCHAR(50),
    IN p_LastName VARCHAR(50),
    IN p_Email VARCHAR(100),
    IN p_Password VARCHAR(255),
    IN p_Phone VARCHAR(15),
    IN p_Address TEXT
)
BEGIN
    DECLARE next_id INT;
    
    -- Find the first available gap in IDs
    SELECT MIN(t1.UserID + 1) INTO next_id
    FROM tbUser t1
    LEFT JOIN tbUser t2 ON t1.UserID + 1 = t2.UserID
    WHERE t2.UserID IS NULL
    AND t1.UserID < (SELECT MAX(UserID) FROM tbUser);

    -- If no gaps found or table is empty, use the next number after max
    IF next_id IS NULL THEN
        SELECT COALESCE(MAX(UserID), 0) + 1 INTO next_id FROM tbUser;
    END IF;
    
    -- Insert with the next available ID
    INSERT INTO tbUser(
        UserID,
        FirstName, 
        LastName, 
        Email, 
        Password,
        Phone,
        Address,
        Role
    ) VALUES (
        next_id,
        p_FirstName,
        p_LastName,
        p_Email,
        p_Password,
        NULLIF(p_Phone, ''),
        NULLIF(p_Address, ''),
        'user'
    );
    
    -- Return the used ID
    SELECT next_id AS UserID;
END //

CREATE PROCEDURE sp_GetUser(IN p_UserID INT)
BEGIN
    SELECT * FROM tbUser WHERE UserID = p_UserID;
END //

CREATE PROCEDURE sp_GetUserByEmail(IN p_Email VARCHAR(100))
BEGIN 
    SELECT * FROM tbUser WHERE Email = p_Email;
END //

CREATE PROCEDURE sp_UpdateUser(
    IN p_UserID INT,
    IN p_FirstName VARCHAR(50),
    IN p_LastName VARCHAR(50),
    IN p_Email VARCHAR(100),
    IN p_Phone VARCHAR(15),
    IN p_Address TEXT,
    IN p_Role ENUM('admin', 'user')
)
BEGIN
    UPDATE tbUser 
    SET FirstName = p_FirstName,
        LastName = p_LastName,
        Email = p_Email,
        Phone = p_Phone,
        Address = p_Address,
        Role = COALESCE(p_Role, Role)
    WHERE UserID = p_UserID;
END //

CREATE PROCEDURE sp_DeleteUser(
    IN p_UserID INT
)
BEGIN
    -- Check if user has orders
    IF EXISTS (SELECT 1 FROM tbOrder WHERE UserID = p_UserID) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Cannot delete user with existing orders';
    ELSE
        DELETE FROM tbCart WHERE UserID = p_UserID;
        DELETE FROM tbWishlist WHERE UserID = p_UserID;
        DELETE FROM tbReview WHERE UserID = p_UserID;
        DELETE FROM tbUser WHERE UserID = p_UserID;
    END IF;
END //

CREATE PROCEDURE sp_UpdateUserPassword(
    IN p_UserID INT,
    IN p_NewPassword VARCHAR(255)
)
BEGIN
    UPDATE tbUser 
    SET Password = p_NewPassword
    WHERE UserID = p_UserID;
    
    IF ROW_COUNT() > 0 THEN
        SELECT 'Password updated successfully' as Message;
    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'User not found';
    END IF;
END //

CREATE PROCEDURE sp_GetAllUsers()
BEGIN
    SELECT 
        u.*,
        COUNT(DISTINCT o.OrderID) as TotalOrders,
        COALESCE(SUM(o.TotalAmount), 0) as TotalSpent
    FROM tbUser u
    LEFT JOIN tbOrder o ON u.UserID = o.UserID
    WHERE u.Role = 'user'
    GROUP BY u.UserID
    ORDER BY u.CreatedAt DESC;
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

-- Product Management Procedures
CREATE PROCEDURE sp_GetAllProducts()
BEGIN
    SELECT p.*, c.Name as CategoryName 
    FROM tbBook p
    LEFT JOIN tbCategory c ON p.CategoryID = c.CategoryID
    ORDER BY p.CreatedAt DESC;
END //

CREATE PROCEDURE sp_InsertProduct(
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
    DECLARE next_id INT;
    
    -- Find the first available gap in IDs
    SELECT MIN(t1.BookID + 1) INTO next_id
    FROM tbBook t1
    LEFT JOIN tbBook t2 ON t1.BookID + 1 = t2.BookID
    WHERE t2.BookID IS NULL
    AND t1.BookID < (SELECT MAX(BookID) FROM tbBook);

    -- If no gaps found or table is empty, use the next number after max
    IF next_id IS NULL THEN
        SELECT COALESCE(MAX(BookID), 0) + 1 INTO next_id FROM tbBook;
    END IF;
    
    -- Insert with the next available ID
    INSERT INTO tbBook(BookID, CategoryID, Title, Author, ISBN, Description, Price, StockQuantity, Image)
    VALUES(
        next_id, 
        p_CategoryID, 
        p_Title, 
        p_Author, 
        NULLIF(p_ISBN, ''), 
        p_Description, 
        p_Price, 
        p_StockQuantity, 
        NULLIF(p_Image, '')
    );
    
    -- Return the used ID
    SELECT next_id AS BookID;
END //

CREATE PROCEDURE sp_UpdateProduct(
    IN p_BookID INT,
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
    UPDATE tbBook 
    SET CategoryID = p_CategoryID,
        Title = p_Title,
        Author = p_Author,
        ISBN = p_ISBN,
        Description = p_Description,
        Price = p_Price,
        StockQuantity = p_StockQuantity,
        Image = CASE 
            WHEN p_Image = '' THEN Image
            ELSE p_Image 
        END
    WHERE BookID = p_BookID;
END //

CREATE PROCEDURE sp_DeleteProduct(
    IN p_BookID INT
)
BEGIN
    DELETE FROM tbBook WHERE BookID = p_BookID;
END //

CREATE PROCEDURE sp_GetProduct(
    IN p_BookID INT
)
BEGIN
    SELECT b.*, c.Name as CategoryName
    FROM tbBook b
    LEFT JOIN tbCategory c ON b.CategoryID = c.CategoryID
    WHERE b.BookID = p_BookID;
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

DELIMITER //

CREATE PROCEDURE sp_GetAllOrders()
BEGIN
    SELECT o.*, u.FirstName, u.LastName, u.Email,
           GROUP_CONCAT(b.Title SEPARATOR ', ') as OrderItems,
           COUNT(od.BookID) as ItemCount
    FROM tbOrder o
    LEFT JOIN tbUser u ON o.UserID = u.UserID
    LEFT JOIN tbOrderDetail od ON o.OrderID = od.OrderID
    LEFT JOIN tbBook b ON od.BookID = b.BookID
    GROUP BY o.OrderID
    ORDER BY o.OrderDate DESC;
END //

CREATE PROCEDURE sp_GetOrderDetails(IN p_OrderID INT)
BEGIN
    SELECT od.*, b.Title, b.Author
    FROM tbOrderDetail od
    JOIN tbBook b ON od.BookID = b.BookID
    WHERE od.OrderID = p_OrderID;
END //

CREATE PROCEDURE sp_UpdateOrderStatus(
    IN p_OrderID INT,
    IN p_Status VARCHAR(20)
)
BEGIN
    UPDATE tbOrder 
    SET Status = p_Status
    WHERE OrderID = p_OrderID;
END //

CREATE PROCEDURE sp_InsertOrder(
    IN p_UserID INT,
    IN p_TotalAmount DECIMAL(10,2),
    IN p_Status VARCHAR(20),
    IN p_ShippingAddress TEXT,
    IN p_PaymentMethod VARCHAR(50)
)
BEGIN
    DECLARE next_id INT;
    
    -- Find the first available gap in IDs
    SELECT MIN(t1.OrderID + 1) INTO next_id
    FROM tbOrder t1
    LEFT JOIN tbOrder t2 ON t1.OrderID + 1 = t2.OrderID
    WHERE t2.OrderID IS NULL
    AND t1.OrderID < (SELECT MAX(OrderID) FROM tbOrder);

    -- If no gaps found or table is empty, use the next number after max
    IF next_id IS NULL THEN
        SELECT COALESCE(MAX(OrderID), 0) + 1 INTO next_id FROM tbOrder;
    END IF;
    
    -- Insert with the next available ID
    INSERT INTO tbOrder(
        OrderID,
        UserID, 
        TotalAmount, 
        Status,
        ShippingAddress, 
        PaymentMethod
    ) VALUES (
        next_id,
        p_UserID,
        p_TotalAmount,
        COALESCE(p_Status, 'pending'),
        p_ShippingAddress,
        p_PaymentMethod
    );
    
    -- Return the used ID
    SELECT next_id AS OrderID;
END //

CREATE PROCEDURE sp_UpdateOrder(
    IN p_OrderID INT,
    IN p_TotalAmount DECIMAL(10,2),
    IN p_Status VARCHAR(20),
    IN p_ShippingAddress TEXT,
    IN p_PaymentMethod VARCHAR(50)
)
BEGIN
    UPDATE tbOrder 
    SET TotalAmount = p_TotalAmount,
        Status = p_Status,
        ShippingAddress = p_ShippingAddress,
        PaymentMethod = p_PaymentMethod
    WHERE OrderID = p_OrderID;
END //

CREATE PROCEDURE sp_DeleteOrder(
    IN p_OrderID INT
)
BEGIN
    START TRANSACTION;
    
    -- First restore book quantities
    UPDATE tbBook b
    JOIN tbOrderDetail od ON b.BookID = od.BookID
    SET b.StockQuantity = b.StockQuantity + od.Quantity
    WHERE od.OrderID = p_OrderID;
    
    -- Delete order details first (due to foreign key constraint)
    DELETE FROM tbOrderDetail 
    WHERE OrderID = p_OrderID;
    
    -- Then delete the main order
    DELETE FROM tbOrder 
    WHERE OrderID = p_OrderID;
    
    COMMIT;
END //

CREATE PROCEDURE sp_InsertOrderDetail(
    IN p_OrderID INT,
    IN p_BookID INT,
    IN p_Quantity INT,
    IN p_Price DECIMAL(10,2)
)
BEGIN
    INSERT INTO tbOrderDetail(
        OrderID,
        BookID,
        Quantity,
        Price
    ) VALUES (
        p_OrderID,
        p_BookID,
        p_Quantity,
        p_Price
    );
    
    -- Update book stock quantity
    UPDATE tbBook 
    SET StockQuantity = StockQuantity - p_Quantity
    WHERE BookID = p_BookID;
END //

CREATE PROCEDURE sp_UpdateOrderDetail(
    IN p_OrderDetailID INT,
    IN p_Quantity INT,
    IN p_Price DECIMAL(10,2)
)
BEGIN
    DECLARE old_quantity INT;
    DECLARE book_id INT;
    
    -- Get current quantity and book ID
    SELECT Quantity, BookID INTO old_quantity, book_id
    FROM tbOrderDetail 
    WHERE OrderDetailID = p_OrderDetailID;
    
    -- Start transaction to ensure data consistency
    START TRANSACTION;
    
    -- Update order detail
    UPDATE tbOrderDetail 
    SET Quantity = p_Quantity,
        Price = p_Price
    WHERE OrderDetailID = p_OrderDetailID;
    
    -- Adjust book stock quantity
    UPDATE tbBook 
    SET StockQuantity = StockQuantity + (old_quantity - p_Quantity)
    WHERE BookID = book_id;
    
    COMMIT;
END //

CREATE PROCEDURE sp_DeleteOrderDetail(
    IN p_OrderDetailID INT
)
BEGIN
    DECLARE book_id INT;
    DECLARE quantity INT;
    
    -- Get the book ID and quantity before deleting
    SELECT BookID, Quantity INTO book_id, quantity
    FROM tbOrderDetail 
    WHERE OrderDetailID = p_OrderDetailID;
    
    -- Start transaction
    START TRANSACTION;
    
    -- Restore book quantity
    UPDATE tbBook 
    SET StockQuantity = StockQuantity + quantity
    WHERE BookID = book_id;
    
    -- Delete the order detail
    DELETE FROM tbOrderDetail 
    WHERE OrderDetailID = p_OrderDetailID;
    
    COMMIT;
END //

DELIMITER ;

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

-- Category Management Procedures
CREATE PROCEDURE sp_GetAllCategories()
BEGIN
    SELECT * FROM tbCategory ORDER BY CreatedAt DESC;
END //

CREATE PROCEDURE sp_InsertCategory(
    IN p_Name VARCHAR(100),
    IN p_Description TEXT
)
BEGIN
    DECLARE next_id INT;
    
    -- Find the first available gap in IDs
    SELECT MIN(t1.CategoryID + 1) INTO next_id
    FROM tbCategory t1
    LEFT JOIN tbCategory t2 ON t1.CategoryID + 1 = t2.CategoryID
    WHERE t2.CategoryID IS NULL;
    
    -- If no gaps found or table is empty, use the next number after max
    IF next_id IS NULL THEN
        SELECT IFNULL(MAX(CategoryID), 0) + 1 INTO next_id FROM tbCategory;
    END IF;
    
    -- Insert with the next available ID
    INSERT INTO tbCategory(CategoryID, Name, Description) 
    VALUES (next_id, p_Name, p_Description);
    
    -- Return the used ID
    SELECT next_id AS CategoryID;
END //

CREATE PROCEDURE sp_UpdateCategory(
    IN p_CategoryID INT,
    IN p_Name VARCHAR(100),
    IN p_Description TEXT
)
BEGIN
    UPDATE tbCategory 
    SET Name = p_Name,
        Description = p_Description
    WHERE CategoryID = p_CategoryID;
END //

CREATE PROCEDURE sp_DeleteCategory(
    IN p_CategoryID INT
)
BEGIN
    DELETE FROM tbCategory WHERE CategoryID = p_CategoryID;
END //

CREATE PROCEDURE sp_GetAllPurchases()
BEGIN
    SELECT p.*, b.Title, b.Author, (p.Quantity * p.UnitPrice) as TotalAmount
    FROM tbPurchase p
    LEFT JOIN tbBook b ON p.BookID = b.BookID
    ORDER BY p.OrderDate DESC;
END //

DROP PROCEDURE IF EXISTS sp_InsertPurchase //

CREATE PROCEDURE sp_InsertPurchase(
    IN p_BookID INT,
    IN p_Quantity INT,
    IN p_PaymentMethod VARCHAR(50)
)
BEGIN
    DECLARE book_price DECIMAL(10,2);
    DECLARE next_id INT;
    
    -- Get book price
    SELECT Price INTO book_price FROM tbBook WHERE BookID = p_BookID;
    
    -- Find the first available gap in IDs
    SELECT MIN(t1.PurchaseID + 1) INTO next_id
    FROM tbPurchase t1
    LEFT JOIN tbPurchase t2 ON t1.PurchaseID + 1 = t2.PurchaseID
    WHERE t2.PurchaseID IS NULL
    AND t1.PurchaseID < (SELECT MAX(PurchaseID) FROM tbPurchase);
    
    -- If no gaps found or table is empty, use the next number after max
    IF next_id IS NULL THEN
        SELECT COALESCE(MAX(PurchaseID), 0) + 1 INTO next_id FROM tbPurchase;
    END IF;
    
    -- Insert with the next available ID
    INSERT INTO tbPurchase(PurchaseID, BookID, Quantity, UnitPrice, PaymentMethod)
    VALUES(next_id, p_BookID, p_Quantity, book_price, p_PaymentMethod);
    
    -- Update book stock
    UPDATE tbBook 
    SET StockQuantity = StockQuantity + p_Quantity
    WHERE BookID = p_BookID;
    
    -- Return the used ID
    SELECT next_id AS PurchaseID;
END //

DROP PROCEDURE IF EXISTS sp_UpdatePurchase //

CREATE PROCEDURE sp_UpdatePurchase(
    IN p_PurchaseID INT,
    IN p_BookID INT,
    IN p_Quantity INT,
    IN p_PaymentMethod VARCHAR(50)
)
BEGIN
    DECLARE old_quantity INT;
    DECLARE old_bookid INT;
    DECLARE new_book_price DECIMAL(10,2);
    
    -- Get old purchase data
    SELECT Quantity, BookID 
    INTO old_quantity, old_bookid
    FROM tbPurchase 
    WHERE PurchaseID = p_PurchaseID;
    
    -- Get new book price
    SELECT Price INTO new_book_price 
    FROM tbBook 
    WHERE BookID = p_BookID;
    
    -- Start transaction
    START TRANSACTION;
    
    -- Revert stock quantity for old book
    UPDATE tbBook 
    SET StockQuantity = StockQuantity - old_quantity
    WHERE BookID = old_bookid;
    
    -- Update purchase record with new book price
    UPDATE tbPurchase 
    SET BookID = p_BookID,
        Quantity = p_Quantity,
        UnitPrice = new_book_price,
        PaymentMethod = p_PaymentMethod
    WHERE PurchaseID = p_PurchaseID;
    
    -- Update stock quantity for new book
    UPDATE tbBook 
    SET StockQuantity = StockQuantity + p_Quantity
    WHERE BookID = p_BookID;
    
    -- Commit transaction
    COMMIT;
    
    -- Return success message
    SELECT 'Purchase updated successfully' as Message;
END //

DROP PROCEDURE IF EXISTS sp_DeletePurchase //

CREATE PROCEDURE sp_DeletePurchase(
    IN p_PurchaseID INT
)
BEGIN
    -- Revert stock quantity before deleting
    UPDATE tbBook b
    JOIN tbPurchase p ON b.BookID = p.BookID
    SET b.StockQuantity = b.StockQuantity - p.Quantity
    WHERE p.PurchaseID = p_PurchaseID;
    
    -- Delete purchase record
    DELETE FROM tbPurchase WHERE PurchaseID = p_PurchaseID;
END //

DELIMITER ;
