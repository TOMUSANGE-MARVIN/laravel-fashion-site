<?php
/* */

namespace InnoShop\Common\Services;

class BaseService
{
    public static function getInstance(): static
    {
        return new static;
    }
}
