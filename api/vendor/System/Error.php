<?php
declare(strict_types = 1);

namespace System;

class Error
{
    public static function handleException(string $msg): void
    {
        header("HTTP/1.0 404 Not Found");
        header('Content-Type: application/json');
        echo json_encode(
            [
                'erro' => true,
                'result' => [str_replace(['\\', '\\\\', '/', '\/'], '', stripslashes($msg))]
            ]
        );
        exit();
    }
}