<?php
/* */

namespace InnoShop\Panel\Repositories;

class BaseRepo
{
    /**
     * @return static
     */
    public static function getInstance(): static
    {
        return new static;
    }
}
