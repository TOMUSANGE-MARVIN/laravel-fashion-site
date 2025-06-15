<?php
/* */

namespace InnoShop\Common\Libraries;

class ViewHook
{
    /**
     * @return self
     */
    public static function getInstance(): ViewHook
    {
        return new self;
    }

    /**
     * @param  $trace
     * @return string
     */
    public function getHookName($trace): string
    {
        $class = $trace[1]['class'] ?? '';
        if (empty($class)) {
            return '';
        }

        $method = strtolower($trace[1]['function'] ?? '');
        if (empty($method)) {
            return '';
        }

        if (! str_starts_with($class, 'InnoShop')) {
            return '';
        }

        $class = str_replace(['InnoShop\\', 'Controllers\\', 'Controller'], '', $class);
        $class = strtolower(str_replace('\\', '.', $class));

        return "$class.$method";
    }
}
