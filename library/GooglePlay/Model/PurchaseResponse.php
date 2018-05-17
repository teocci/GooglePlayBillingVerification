<?php

namespace ReceiptValidator\GooglePlay;
/**
 * Created by IntelliJ IDEA.
 * User: teocci
 * Date: 5/16/18
 * Time: 3:01 PM
 */
class PurchaseResponse extends AbstractResponse
{
    /**
     * @var \Google_Service_AndroidPublisher_ProductPurchase
     */
    protected $response;
    protected $developerPayload = [];

    public function __construct($response)
    {
        parent::__construct($response);
        $this->developerPayload = json_decode($this->response->getDeveloperPayload(), true);
    }

    /**
     * @return int
     */
    public function getConsumptionState()
    {
        return $this->response->getConsumptionState();
    }

    /**
     * @return string
     */
    public function getPurchaseTimeMillis()
    {
        return $this->response->getPurchaseTimeMillis();
    }

    public function getDeveloperPayload()
    {
        return $this->developerPayload;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getDeveloperPayloadElement($key)
    {
        return (isset($this->developerPayload[$key])) ? $this->developerPayload[$key] : '';
    }

    /**
     * @return string
     */
    public function getPurchaseState()
    {
        return $this->response->getPurchaseState();
    }
}