<?php
/* */

namespace InnoShop\Common\Libraries;

use Exception;

class Breadcrumb
{
    public static function getInstance(): Breadcrumb
    {
        return new self;
    }

    /**
     * @param  $type
     * @param  $object
     * @param  string  $title
     * @return array
     * @throws Exception
     */
    public function getTrail($type, $object, string $title = ''): array
    {
        if (in_array($type, ['category', 'product', 'tag'])) {
            return [
                'title' => $object->fallbackName('name'),
                'url'   => $object->url,
            ];
        } elseif (in_array($type, ['catalog', 'article', 'page'])) {
            return [
                'title' => $object->fallbackName('title'),
                'url'   => $object->url,
            ];
        } elseif ($type == 'brand') {
            return [
                'title' => $object->name,
                'url'   => $object->url,
            ];
        } elseif ($type == 'order') {
            return [
                'title' => $object->number,
                'url'   => account_route('orders.number_show', ['number' => $object->number]),
            ];
        } elseif ($type == 'order_return') {
            return [
                'title' => $object->number,
                'url'   => account_route('order_returns.show', ['order_return' => $object->id]),
            ];
        } elseif ($type == 'route') {
            if (empty($title)) {
                $title = front_trans('common.'.str_replace('.', '_', $object));
            }

            return [
                'title' => $title,
                'url'   => front_route($object),
            ];
        } elseif ($type == 'static') {
            return [
                'title' => $title,
                'url'   => $object,
            ];
        }

        return [];
    }
}
