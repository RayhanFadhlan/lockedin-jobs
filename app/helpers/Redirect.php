<?php
namespace helpers;
class Redirect
{
    public static function to($url, $statusCode = 302)
    {
        header('Location: ' . $url, true, $statusCode);
        exit();
    }

    public static function back()
    {
        self::to($_SERVER['HTTP_REFERER'] ?? '/');
    }

    public static function withMessage($url, $message, $type = 'info')
    {
        $_SESSION['flash_message'] = [
            'message' => $message,
            'type' => $type
        ];
        self::to($url);
    }
}