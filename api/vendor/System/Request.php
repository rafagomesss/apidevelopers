<?php

declare(strict_types = 1);

namespace System;

class Request
{
    private string $controller;
    private string $method;
    private array $args = [];
    
    public function __construct()
    {
        $this->defineRequest();
    }

    private function defineRequest(): void
    {
        $url = '/';
        $getUrl = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
        if (!empty($getUrl)) {
            $url .= $getUrl;
        }
        $url = $this->verifyRoutes($url);
        $url = !empty($url) && $url !== '/' ? explode('/', substr($url,1)) : [];

        if (!empty($url[0]) && $url[0] !== 'developers') {
            header("HTTP/1.1 404 Not Found");
            exit();
        }

        $this->controller = !empty($url[0]) ? array_shift($url) : 'Index';
        $this->method = !empty($url[0]) ? array_shift($url) : 'main';
        $this->args = !empty($url) ? $url : [];
    }

    private function verifyRoutes($url): string
    {
        $routes = Routes::returnRoutes();

        foreach($routes as $pt => $newurl) {

			// Identifica os argumentos e substitui por regex
			$pattern = preg_replace('(\{[a-z0-9]{1,}\})', '([a-z0-9-]{1,})', $pt);

			// Faz o match da URL
			if(preg_match('#^('.$pattern.')*$#i', $url, $matches) === 1) {
				array_shift($matches);
				array_shift($matches);

				// Pega todos os argumentos para associar
				$itens = [];
				if(preg_match_all('(\{[a-z0-9]{1,}\})', $pt, $m)) {
					$itens = preg_replace('(\{|\})', '', $m[0]);
				}

				// Faz a associação
				$arg = [];
				foreach($matches as $key => $match) {
					$arg[$itens[$key]] = $match;
				}

				// Monta a nova url
				foreach($arg as $argkey => $argvalue) {
					$newurl = str_replace(':'.$argkey, $argvalue, $newurl);
				}

				$url = $newurl;
				break;
			}
		}
		return $url;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function setController($controller): Request
    {
        $this->controller = $controller;

        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod($method): Request
    {
        $this->method = $method;

        return $this;
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    public function setArgs($args): Request
    {
        $this->args = $args;

        return $this;
    }
}