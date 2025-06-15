<?php
/* */

namespace InnoShop\Panel\Interfaces;

interface Translator
{
    public function translate($from, $to, $text): string;

    public function batchTranslate($from, $to, $texts): array;

    public function mapCode($code): string;
}
