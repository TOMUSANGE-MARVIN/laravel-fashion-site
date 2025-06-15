<?php
/* */

namespace InnoShop\Common\Traits;

trait Replicate
{
    public function deepReplicate(?array $except = null)
    {
        $copy = parent::replicate($except);
        $copy->push();

        foreach ($this->getRelations() as $relation => $entries) {
            foreach ($entries as $entry) {
                $newEntry = $entry->replicate();
                if ($newEntry->push()) {
                    $copy->{$relation}()->save($copy);
                }
            }
        }

        return $copy;
    }
}
