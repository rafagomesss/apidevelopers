<?php
declare(strict_types = 1);

namespace System;

use System\{
    Request,
    Error
};

class Router
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    private function validateControllerMethod(string $controller, string $method): void
    {
        $controller = mb_convert_case($this->request->getController(), MB_CASE_TITLE, 'UTF8');
        $method = mb_convert_case($this->request->getMethod(), MB_CASE_TITLE, 'UTF8');
        if (!$this->classExistsRouter()) {
            $customerException =  "O controlador: \"{$controller}\" não existe!";
            Error::handleException($customerException);
            exit();
        }

        if (!$this->methodExistsRouter()) {
            $customerException = "O método: \"{$method}\" não existe!";
            Error::handleException($customerException);
            exit();
        }
    }

    private function classExistsRouter(): bool
    {
        return class_exists(
            'Api\\Controller\\' . mb_convert_case($this->request->getController(), 
            MB_CASE_TITLE, 
            'UTF8')
        );
    }

    private function methodExistsRouter(): bool
    {
        return method_exists(
            'Api\\Controller\\' . mb_convert_case($this->request->getController(),
            MB_CASE_TITLE,
            'UTF8'),
            $this->request->getMethod()
        );
    }

    public function run()
    {
        $controller = 'Api\\Controller\\' . mb_convert_case($this->request->getController(), MB_CASE_TITLE, 'UTF8');
        $method = $this->request->getMethod();
        $args = $this->request->getArgs();
        $this->validateControllerMethod($controller, $method);
        $response = call_user_func_array([
            new $controller, 
            $method], 
            $args
        );
        print $response;
    }
}