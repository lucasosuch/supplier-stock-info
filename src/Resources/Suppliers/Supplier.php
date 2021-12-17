<?php

namespace StanleyStella\Resources\Suppliers;

abstract class Supplier
{
    protected string $token;
    protected string $query;
    protected \CurlHandle $curlHandle;

    public function __construct($token)
    {
        $this->query = "";
        $this->token = $token;
    }

    public function results() : array
    {
        $success = true;
        $result = curl_exec($this->curlHandle);

        if (empty($result)) {
            $success = false;
            $httpCode = curl_getinfo($this->curlHandle , CURLINFO_HTTP_CODE);
            $result = $httpCode ." ". curl_error($this->curlHandle);
        }

        curl_close($this->curlHandle);

        return [
            "success" => $success,
            "results" => $this->validateResult($result)
        ];
    }

    public abstract function initConnection();
    public abstract function setQuery(array $query);
    protected abstract function validateResult($result);
}