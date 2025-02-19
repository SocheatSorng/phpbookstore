<?php
class ImageHandler {
    private $baseUploadPath;
    private $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    private $maxFileSize = 5242880; // 5MB
    
    public function __construct() {
        // Set base upload path relative to project root
        $this->baseUploadPath = dirname(dirname(dirname(__FILE__))) . '/public/uploads/products/';
        error_log("Base Upload Path: " . $this->baseUploadPath);
        $this->initializeDirectories();
    }
    
    private function initializeDirectories() {
        $year = date('Y');
        $month = date('m');
        $paths = [
            $this->baseUploadPath,
            $this->baseUploadPath . $year,
            $this->baseUploadPath . $year . '/' . $month,
            $this->baseUploadPath . $year . '/' . $month . '/thumbnails'
        ];
        
        foreach ($paths as $path) {
            if (!file_exists($path)) {
                error_log("Creating directory: " . $path);
                if (!mkdir($path, 0755, true)) {
                    error_log("Failed to create directory: " . $path);
                    throw new Exception('Failed to create directory: ' . $path);
                }
            }
        }
    }
    
    public function uploadImage($file) {
        error_log("Starting upload process for file: " . $file['name']);
        
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            error_log("File upload error: " . $file['error']);
            throw new Exception('Upload failed with error code: ' . $file['error']);
        }
        
        // Validate file
        $this->validateFile($file);
        
        // Generate paths
        $year = date('Y');
        $month = date('m');
        $fileName = $this->generateFileName($file);
        $relativePath = "uploads/products/$year/$month/$fileName";
        $fullPath = $this->baseUploadPath . $year . '/' . $month . '/' . $fileName;
        
        error_log("Generated full path: " . $fullPath);
        error_log("Relative path for DB: " . $relativePath);
        
        // Check if source file exists and is readable
        if (!file_exists($file['tmp_name'])) {
            error_log("Temp file does not exist: " . $file['tmp_name']);
            throw new Exception('Temporary upload file missing');
        }
        
        if (!is_readable($file['tmp_name'])) {
            error_log("Temp file is not readable: " . $file['tmp_name']);
            throw new Exception('Cannot read temporary upload file');
        }
        
        // Check if target directory is writable
        $targetDir = dirname($fullPath);
        if (!is_writable($targetDir)) {
            error_log("Target directory is not writable: " . $targetDir);
            throw new Exception('Upload directory is not writable');
        }
        
        // Move uploaded file
        error_log("Attempting to move file from {$file['tmp_name']} to {$fullPath}");
        if (!move_uploaded_file($file['tmp_name'], $fullPath)) {
            $moveError = error_get_last();
            error_log("Move failed. PHP error: " . print_r($moveError, true));
            throw new Exception('Failed to move uploaded file');
        }
        
        error_log("File successfully moved to: " . $fullPath);
        
        // Verify file was actually moved
        if (!file_exists($fullPath)) {
            error_log("File does not exist at destination: " . $fullPath);
            throw new Exception('File not found at destination after move');
        }
        
        // Create thumbnail
        try {
            $this->createThumbnail($fullPath, dirname($fullPath) . '/thumbnails/' . $fileName);
            error_log("Thumbnail created successfully");
        } catch (Exception $e) {
            error_log("Thumbnail creation failed: " . $e->getMessage());
            // Continue even if thumbnail creation fails
        }
        
        return $relativePath;
    }
    
    private function validateFile($file) {
        // Check file size
        if ($file['size'] > $this->maxFileSize) {
            throw new Exception('File is too large. Maximum size is ' . ($this->maxFileSize / 1024 / 1024) . 'MB');
        }
        
        // Check file type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        error_log("File mime type: " . $mimeType);
        
        if (!in_array($mimeType, $this->allowedTypes)) {
            throw new Exception('Invalid file type. Only JPG, PNG and GIF are allowed');
        }
    }
    
    private function generateFileName($file) {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        return uniqid('book_') . '_' . time() . '.' . $extension;
    }
    
    private function createThumbnail($sourcePath, $targetPath, $maxWidth = 300) {
        list($width, $height) = getimagesize($sourcePath);
        $ratio = $width / $height;
        $newWidth = min($width, $maxWidth);
        $newHeight = $newWidth / $ratio;
        
        $thumb = imagecreatetruecolor($newWidth, $newHeight);
        
        switch (mime_content_type($sourcePath)) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $source = imagecreatefrompng($sourcePath);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($sourcePath);
                break;
            default:
                throw new Exception('Unsupported image type');
        }
        
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagejpeg($thumb, $targetPath, 80);
        
        imagedestroy($thumb);
        imagedestroy($source);
    }
    
    public function deleteImage($relativePath) {
        $fullPath = dirname(dirname(dirname(__FILE__))) . '/public/' . $relativePath;
        $thumbPath = str_replace(basename($relativePath), 'thumbnails/' . basename($relativePath), $fullPath);
        
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }
    }
}