<?php
/* */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use InnoShop\Common\Models\TaxClass;
use InnoShop\Common\Models\TaxRate;

class TaxSeeder extends Seeder
{
    public function run(): void
    {
        $items = $this->getTaxRates();
        if ($items) {
            TaxRate::query()->truncate();
            foreach ($items as $item) {
                TaxRate::query()->create($item);
            }
        }

        $items = $this->getTaxClasses();
        if ($items) {
            TaxClass::query()->truncate();
            foreach ($items as $item) {
                TaxClass::query()->create($item);
            }
        }
    }

    /**
     * @return array[]
     */
    private function getTaxRates(): array
    {
        return [
            [
                'id'        => 1,
                'region_id' => 1,
                'name'      => 'Test Tax',
                'type'      => 'fixed',
                'rate'      => 2,
            ],
            [
                'id'        => 2,
                'region_id' => 1,
                'name'      => 'Demo Tax',
                'type'      => 'percent',
                'rate'      => 10,
            ],
        ];
    }

    /**
     * @return array[]
     */
    private function getTaxClasses(): array
    {
        return [
            [
                'id'          => 1,
                'name'        => 'Fashion',
                'description' => 'Fashion Tax',
            ],
        ];
    }
}
