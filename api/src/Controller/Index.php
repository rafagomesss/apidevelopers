<?php

declare(strict_types = 1);

namespace Api\Controller;

use Api\Controller\Controller;

class Index extends Controller
{
    public function main(): void
    {
        $array = ['nome' => 'Antônio', 'idade' => 23];
        $this->returnJson($array);
    }
}