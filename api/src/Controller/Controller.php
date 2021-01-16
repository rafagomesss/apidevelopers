<?php

declare(strict_types = 1);

namespace Api\Controller;

class Controller
{
    protected function responseArray(bool $erro, array $response): array
    {
        return ['erro' => $erro, 'result' => $response];
    }

    public function getMethod() 
    {
        return filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);
    }

    public function getRequestData()
    {
        switch($this->getMethod()) {
            case 'GET': 
                return filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
                break;
            case 'PUT':
            case 'DELETE':
                $data = json_decode(file_get_contents('php://input'), true);
                return $data;
                break;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'));
                if (is_null($data)) {
                    $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                }
                return (array) $data;
                break;
        }
        
    }

    public function returnJson(array $array)
    {
        header('Content-Type: application/json');
        echo json_encode($array);
        exit();
    }
}