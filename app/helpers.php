<?php

if (! function_exists('url_anh_public')) {
    /**
     * URL tới file trong storage/app/public (qua symlink public/storage).
     * Dùng đường dẫn tuyệt đối từ root site (/storage/...) để ảnh luôn đúng domain
     * đang truy cập — tránh vỡ ảnh khi APP_URL trong .env khác với virtual host (Laragon).
     */
    function url_anh_public(?string $path): string
    {
        if ($path === null || $path === '') {
            return '';
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        $path = str_replace('\\', '/', ltrim($path, '/'));

        return '/storage/'.$path;
    }
}

if (! function_exists('tao_anh_giay_lap')) {
    /**
     * Tạo ảnh placeholder đơn giản và lưu vào public/storage/{folder}
     * Trả về đường dẫn tương đối đến file từ root public/storage
     */
    function tao_anh_giay_lap(string $folder, ?string $text = null): string
    {
        $width = 400;
        $height = 300;
        
        // Tạo ảnh
        $image = imagecreatetruecolor($width, $height);
        
        // Màu sắc ngẫu nhiên
        $colors = [
            imagecolorallocate($image, 52, 152, 219),   // blue
            imagecolorallocate($image, 46, 204, 113),   // green
            imagecolorallocate($image, 155, 89, 182),   // purple
            imagecolorallocate($image, 230, 126, 34),   // orange
            imagecolorallocate($image, 231, 76, 60),    // red
        ];
        
        $bgColor = $colors[array_rand($colors)];
        imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);
        
        // Chữ trắng
        $textColor = imagecolorallocate($image, 255, 255, 255);
        $displayText = $text ?? 'Placeholder';
        
        // Ghi chữ giữa ảnh (dùng built-in font)
        imagestring($image, 5, ($width - strlen($displayText) * 8) / 2, $height / 2 - 10, $displayText, $textColor);
        
        // Đảm bảo folder tồn tại
        $storagePath = public_path('storage/' . $folder);
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0755, true);
        }
        
        // Lưu file
        $filename = uniqid() . '_' . time() . '.jpg';
        $filepath = $storagePath . '/' . $filename;
        imagejpeg($image, $filepath, 85);
        imagedestroy($image);
        
        return $folder . '/' . $filename;
    }
}
