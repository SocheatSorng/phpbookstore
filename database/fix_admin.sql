-- First, clean any existing admin user
DELETE FROM tbUser WHERE Email = 'admin@admin.com';

-- Insert admin with properly generated hash for 'admin123'
INSERT INTO tbUser (FirstName, LastName, Email, Password, Role) 
VALUES (
    'Admin', 
    'User', 
    'admin@admin.com', 
    '$2y$10$KF7EH9RscnwRGC2o3wEiseQqrTLBv3IiWjT7g0hKCCM4BFGLpV0Aq', -- New hash for 'admin123'
    'admin'
);
