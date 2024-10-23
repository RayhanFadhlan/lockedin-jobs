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

    public static function withToast($url, $message, $type = 'default')
    {
    
        setcookie('toastMessage', $message, time() + 60, '/');
        setcookie('toastType', $type, time() + 60, '/');
        self::to($url);
    }
}