<?php

namespace SupplierStockInfo\Resources\Suppliers;

class StanleyStella extends Supplier
{
    const URL = "https://webservices.stanleystella.com/ODatav4/StockOverview";
    const IDENTIFIER = "SKU";

    /**
     * @param array $query
     * @return void
     * @throws \Exception
     */
    public function setQuery(array $query): void
    {
        if(empty($query)) {
            throw new \Exception("Please provide a items for search");
        }

        $this->query = rawurlencode(self::IDENTIFIER." eq '". $query['identifier']."'");
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function initConnection(): void
    {
        $this->curlHandle = curl_init(self::URL .'?$filter='. $this->query);
        curl_setopt($this->curlHandle, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curlHandle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($this->curlHandle, CURLOPT_USERPWD, $this->token);
        curl_setopt($this->curlHandle, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    }

    /**
     * @param $result
     * @return array
     */
    protected function convertResult($result): array
    {
        $result = json_decode($result, true);

        foreach($result['value'] as $iter =>$item) {
            if(!empty($item['Is_Inventory'])) {
                return $result['value'][$iter];
            }
        }

        return [];
    }
}