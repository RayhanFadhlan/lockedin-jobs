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

    public static function withToast($url, $message)
    {
        $_SESSION['toastMessage'] = $message;
        self::to($url);
    }
}