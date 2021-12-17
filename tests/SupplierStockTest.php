<?php

use PHPUnit\Framework\TestCase;
use StanleyStella\SupplierStock;

class SupplierStockTest extends TestCase
{
    public function testIfSupplierExists()
    {
        $this->expectException(Exception::class);

        $supplierStock = new SupplierStock();
        $supplierStock->suppliers([
            [
                'name' => 'dummy-supplier',
                'token' => 'token'
            ]
        ]);
    }

    public function testIfConnectionCanBeEstablished()
    {
        $this->expectException(Exception::class);

        $supplierStock = new SupplierStock();
        $supplierStock->suppliers([
            [
                'name' => 'stanley-stella',
                'token' => 'token'
            ]
        ])->items([
            [
                'SKU' => 'STTU787C6021S',
                'Is_Inventory' => true
            ]
        ]);
    }
}
