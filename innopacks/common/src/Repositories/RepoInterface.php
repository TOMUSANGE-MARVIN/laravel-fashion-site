<?php
/* */

namespace InnoShop\Common\Repositories;

interface RepoInterface
{
    public function list(array $filters = []);

    public function all(array $filters = []);

    public function detail(int $id);

    public function create($data);

    public function update(mixed $item, $data);

    public function destroy(mixed $item);

    public function builder(array $filters = []);
}
