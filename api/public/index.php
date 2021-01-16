<?php

use System\{
    Error,
    Router, 
    Request
};

require_once '../vendor/autoload.php';

require_once '../config/db.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE");

try {
    (new Router(new Request()))->run();
} catch(\Exception $ex) {
    $customException = 'File: ' . $ex->getFile() . 
        ' Line: ' . $ex->getLine() . ' Code: ' . $ex->getCode() .
        ' Message: ' . $ex->getMessage();
    Error::handleException($customException);
    exit();
} catch(\Throwable $th) {
    $customThrowable = 'File: ' . $th->getFile() . 
        ' Line: ' . $th->getLine() . ' Code: ' . $th->getCode() .
        ' Message: ' . $th->getMessage();
    Error::handleException($customThrowable);
    exit();
}