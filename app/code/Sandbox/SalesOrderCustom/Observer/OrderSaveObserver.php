<?php
namespace Sandbox\SalesOrderCustom\Observer;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

/**
 * Class OrderSaveObserver
 * @package Sandbox\SalesOrderCustom\Observer
 */
class OrderSaveObserver implements ObserverInterface
{
    protected RequestInterface $request;

    /**
     * @param RequestInterface $request
     */
    public function __construct(
        RequestInterface $request
    )
    {
        $this->request = $request;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $postcode = $this->request->getParam('postcode');
        $order = $observer->getEvent()->getOrder();

        if($postcode){
            $order->setPostcode($postcode);
        }
    }
}
