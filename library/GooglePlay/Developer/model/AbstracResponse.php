<?php

namespace ReceiptValidator\GooglePlay;
/**
 * Created by IntelliJ IDEA.
 * User: teocci
 * Date: 5/16/18
 * Time: 2:59 PM
 */
abstract class AbstractResponse
{
    const CONSUMPTION_STATE_YET_TO_BE_CONSUMED = 0;
    const CONSUMPTION_STATE_CONSUMED = 1;

    const PURCHASE_STATE_PURCHASED = 0;
    const PURCHASE_STATE_CANCELED = 1;
    /**
     * @var \Google_Service_AndroidPublisher_ProductPurchase|\Google_Service_AndroidPublisher_SubscriptionPurchase
     */
    protected $response;
    /**
     * Constructor
     *
     * @param \Google_Service_AndroidPublisher_ProductPurchase|\Google_Service_AndroidPublisher_SubscriptionPurchase $response
     */
    public function __construct($response)
    {
        $this->response = $response;
    }
    /**
     * @return array|string
     */
    public function getDeveloperPayload()
    {
        return $this->response->getDeveloperPayload();
    }
    /**
     * @return string
     */
    public function getKind()
    {
        return $this->response->getKind();
    }
    /**
     * @return \Google_Service_AndroidPublisher_ProductPurchase|\Google_Service_AndroidPublisher_SubscriptionPurchase
     */
    public function getRawResponse()
    {
        return $this->response;
    }
}