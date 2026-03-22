<?php
/**
 * ImageHelper Class
 * Handles Image Upload, Conversion to WebP, Optimization, and Deletion
 */

class ImageHelper {
    
    /**
     * Upload and optimize image to WebP format
     * 
     * @param array $file The $_FILES['input_name'] array
     * @param string $directory Target directory (e.g., 'uploads/categories/')
     * @param int $quality Quality of WebP (0-100)
     * @return string|bool Returns the relative file path on success, false on failure
     */
    public static function upload($file, $directory, $quality = 80) {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        // Create directory if not exists
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $sourcePath = $file['tmp_name'];
        $imageInfo = getimagesize($sourcePath);
        
        if (!$imageInfo) return false;

        $mime = $imageInfo['mime'];
        
        // Create image from source
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($sourcePath);
                // Maintain transparency for WebP
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($sourcePath);
                break;
            default:
                return false;
        }

        // Generate final filename
        $filename = time() . '_' . uniqid() . '.webp';
        $destinationPath = rtrim($directory, '/') . '/' . $filename;

        // Convert to WebP and save
        // We adjust quality to aim for ~100KB. If the image is huge, we might need more aggressive compression.
        // For now, we use the provided quality or default 80.
        imagewebp($image, $destinationPath, $quality);
        
        // Clean up memory
        imagedestroy($image);

        return $destinationPath;
    }

    /**
     * Delete an image from storage
     * 
     * @param string $filePath Relative or absolute path to the file
     */
    public static function delete($filePath) {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
?>
