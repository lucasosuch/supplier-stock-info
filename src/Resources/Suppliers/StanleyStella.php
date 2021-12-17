<?php

namespace StanleyStella\Resources\Suppliers;

class StanleyStella extends Supplier
{
    const URL = "https://webservices.stanleystella.com/ODatav4/StockOverview";
    private bool $isInventory = false;

    public function setQuery(array $query)
    {
        foreach($query as $key => $value) {
            if($key == 'Is_Inventory' && $value) {
                $this->isInventory = true;
                continue;
            }

            $this->query .= $key." eq '". $value."'";
        }

        $this->query = rawurlencode($this->query);
    }

    public function initConnection()
    {
        $url = self::URL;

        if(!empty($this->query)) {
            $url .= '?$filter='. $this->query;
        }

        $this->curlHandle = curl_init($url);
        curl_setopt($this->curlHandle, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curlHandle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($this->curlHandle, CURLOPT_USERPWD, $this->token);
        curl_setopt($this->curlHandle, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    }

    protected function validateResult($result)
    {
        $result = json_decode($result, true);

        if(!$this->isInventory) {
            return $result;
        }


        foreach($result['value'] as $iter =>$item) {
            if(empty($item['Is_Inventory'])) {
                unset($result['value'][$iter]);
            }
        }

        return $result;
    }
}