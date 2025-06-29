<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use InnoShop\Common\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $items = $this->getAdmins();
        if ($items) {
            Admin::query()->truncate();
            foreach ($items as $item) {
                Admin::query()->create($item);
            }
        }
    }

    /**
     * @return array[]
     */
    private function getAdmins(): array
    {
        return [
            [
                'name'     => 'admin',
                'email'    => 'admin@innoshop.com',
                'password' => '$2y$10$tsjDyAkcFU0qWuJpo3pAae/6PwtQi/AhSR4giHqmjehTJb4B0W0fi',
                'active'   => true,
                'locale'   => 'en',
            ],
        ];
    }
}
