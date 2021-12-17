<?php

namespace StanleyStella;

use StanleyStella\Resources\Suppliers\StanleyStella;

class SupplierStock
{
    const AVAILABLE_SUPPLIERS = [
        'stanley-stella' => StanleyStella::class
    ];

    private array $pickedSuppliers;

    /**
     * @throws \Exception
     */
    public function suppliers(array $suppliersData): static
    {
        foreach($suppliersData as $suppliersDatum) {
            if(!isset(self::AVAILABLE_SUPPLIERS[$suppliersDatum['name']])) {
                throw new \Exception();
            }

            $supplierClass = self::AVAILABLE_SUPPLIERS[$suppliersDatum['name']];
            $this->pickedSuppliers[$suppliersDatum['name']] = new $supplierClass($suppliersDatum['token']);
        }

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function items(array $items): array
    {
        $data = [];

        foreach($this->pickedSuppliers as $supplierName => $supplier) {
            foreach($items as $item) {
                $supplier->setQuery($item);
                $supplier->initConnection();
                $results = $supplier->results();

                if(!$results['success']) {
                    throw new \Exception($results['results']);
                }

                $data[$supplierName] = $results['results'];
            }
        }

        return $data;
    }
}