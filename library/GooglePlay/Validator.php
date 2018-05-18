<?php

namespace ReceiptValidator\GooglePlay;
use ReceiptValidator\GooglePlay\Model\PurchaseResponse;
use ReceiptValidator\GooglePlay\Model\SubscriptionResponse;

/**
 * Created by IntelliJ IDEA.
 * User: teocci
 * Date: 5/16/18
 * Time: 3:10 PM
 */
class Validator
{
    /**
     * @var \Google_Service_AndroidPublisher
     */
    protected $androidPublisherService = null;
    /**
     * @var string
     */
    protected $packageName = null;
    /**
     * @var string
     */
    protected $purchaseToken = null;
    /**
     * @var string
     */
    protected $productId = null;
    /**
     * True for purchases and false for subscriptions
     * @var bool
     */
    private $validationMode = true;

    /**
     * Validator constructor.
     * @param \Google_Service_AndroidPublisher $publisher
     * @param boolean $is_purchase
     */
    public function __construct(\Google_Service_AndroidPublisher $publisher, $is_purchase = true)
    {
        $this->androidPublisherService = $publisher;
        $this->validationMode = $is_purchase;
    }

    /**
     *
     * @param string $package_name
     * @return $this
     */
    public function setPackageName($package_name)
    {
        $this->packageName = $package_name;
        return $this;
    }

    /**
     *
     * @param string $purchase_token
     * @return $this
     */
    public function setPurchaseToken($purchase_token)
    {
        $this->purchaseToken = $purchase_token;
        return $this;
    }

    /**
     *
     * @param string $product_id
     * @return $this
     */
    public function setProductId($product_id)
    {
        $this->productId = $product_id;
        return $this;
    }

    /**
     * @param bool $validation_mode
     * @return Validator
     */
    public function setValidationModepurchase($validation_mode)
    {
        $this->validationMode = $validation_mode;
        return $this;
    }

    /**
     * @return PurchaseResponse|SubscriptionResponse
     */
    public function validate()
    {
        return ($this->validationMode) ? $this->validatePurchase() : $this->validateSubscription();
    }

    /**
     * @return PurchaseResponse
     */
    public function validatePurchase()
    {
        return new PurchaseResponse(
            $this->androidPublisherService->purchases_products->get(
                $this->packageName,
                $this->productId,
                $this->purchaseToken
            )
        );
    }

    /**
     * @return SubscriptionResponse
     */
    public function validateSubscription()
    {
        return new SubscriptionResponse(
            $this->androidPublisherService->purchases_subscriptions->get(
                $this->packageName,
                $this->productId,
                $this->purchaseToken
            )
        );
    }

    /**
     * @return \Google_Service_AndroidPublisher
     */
    public function getPublisherService()
    {
        return $this->androidPublisherService;
    }
}