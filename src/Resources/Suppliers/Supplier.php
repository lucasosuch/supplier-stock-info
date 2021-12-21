<?php

namespace SupplierStockInfo\Resources\Suppliers;

abstract class Supplier
{
    /**
     * @var string
     */
    protected string $token;

    /**
     * @var string
     */
    protected string $query = "";

    /**
     * @var \CurlHandle
     */
    protected \CurlHandle $curlHandle;

    /**
     * @param $token
     * @throws \Exception
     */
    public function __construct($token)
    {
        if(empty($token)) {
            throw new \Exception("Please provide a valid token");
        }

        $this->token = $token;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function results() : array
    {
        $result = curl_exec($this->curlHandle);

        if (empty($result)) {
            $httpCode = curl_getinfo($this->curlHandle , CURLINFO_HTTP_CODE);
            throw new \Exception($httpCode. " | ". curl_error($this->curlHandle));
        }

        curl_close($this->curlHandle);
        return $this->convertResult($result);
    }

    /**
     * @return void
     */
    public abstract function initConnection(): void;

    /**
     * @param array $query
     * @return void
     */
    public abstract function setQuery(array $query): void;

    /**
     * @param $result
     * @return array
     */
    protected abstract function convertResult($result): array;
}