<?php

use PHPUnit\Framework\TestCase;
use SupplierStockInfo\SupplierStock;

class SupplierStockTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
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

    /**
     * @return void
     * @throws Exception
     */
    public function testIfConnectionCanBeEstablished()
    {
        $this->expectException(Exception::class);

        $supplierStock = new SupplierStock();
        $supplierStock->suppliers([
            [
                'name' => 'stanley-stella',
                'token' => 'token',
            ]
        ])->items([
            [
                'identifier' => '123'
            ]
        ])->get();
    }
}
