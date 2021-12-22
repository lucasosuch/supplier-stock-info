<?php

namespace SupplierStockInfo;

use SupplierStockInfo\Resources\Suppliers\StanleyStella;

class SupplierStock
{
    public const AVAILABLE_SUPPLIERS = [
        'stanley-stella' => StanleyStella::class
    ];

    /**
     * @var array
     */
    private array $items = [];

    /**
     * @var array
     */
    private array $pickedSuppliers;

    /**
     * @throws \Exception
     */
    public function suppliers(array $suppliers): static
    {
        if (empty($suppliers)) {
            throw new \Exception("Please provide at least one supplier");
        }

        foreach ($suppliers as $supplier) {
            if (!isset(self::AVAILABLE_SUPPLIERS[$supplier['name']])) {
                throw new \Exception($supplier['name']. " - this supplier is not supported");
            }

            $supplierClass = self::AVAILABLE_SUPPLIERS[$supplier['name']];
            $this->pickedSuppliers[$supplier['name']] = new $supplierClass(
                $supplier['token']
            );
        }

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function items(array $items): static
    {
        if (empty($items)) {
            throw new \Exception("Please provide at least one item");
        }

        foreach ($items as $key => $item) {
            $this->items[$key] = [
                'identifier' => $item['identifier'],
                'stocks' => []
            ];

            foreach ($this->pickedSuppliers as $supplierName => $supplier) {
                $supplier->setQuery($item);
                $supplier->initConnection();
                $result = $supplier->results();

                $this->items[$key]['stocks'][] = array_merge(
                    $result,
                    ['supplier_name' => $supplierName]
                );
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->items;
    }
}
