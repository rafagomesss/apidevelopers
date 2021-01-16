<?php

declare(strict_types = 1);

namespace Api\Model;

use Api\DB\Connection;

class Model
{
    protected string $table = 'developers';
    protected $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }
}