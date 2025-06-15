<?php
/* */

namespace InnoShop\Panel\Services;

class BaseService
{
    /**
     * @return static
     */
    public static function getInstance(): static
    {
        return new static;
    }
}
