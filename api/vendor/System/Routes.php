<?php

declare(strict_types = 1);

namespace System;

class Routes
{
    public static function returnRoutes(): array
    {
        return [
            '/developers' => '/developers/getAll',
            '/developers/new' => '/developers/registerDeveloper',
            '/developers/update/{id}' => '/developers/updateDeveloper/:id',
            '/developers/{id}' => '/developers/findById/:id',
            '/developers/delete/{id}' => '/developers/deleteDeveloper/:id',
        ];
    }
}