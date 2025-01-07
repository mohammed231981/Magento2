<?php declare(strict_types = 1);

namespace Sandbox\SalesOrderCustom\Plugin;

use Magento\Framework\App\RequestInterface;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Class OrderRepositoryPlugin
 * @package Sandbox\SalesOrderCustom\Plugin
 */
class OrderRepositoryPlugin
{
    protected OrderExtensionFactory $extensionFactory;

    /**
     * @param OrderExtensionFactory $extensionFactory
     * @param RequestInterface $request
     */
    public function __construct(
        OrderExtensionFactory $extensionFactory
    )
    {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $order): OrderInterface
    {
        $customerFeedback = $order->getData('postcode');
        $extensionAttributes = $order->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ?: $this->extensionFactory->create();
        $extensionAttributes->setPostcode($customerFeedback);
        $order->setExtensionAttributes($extensionAttributes);

        return $order;
    }

    public function beforeSave(
        \Magento\Sales\Api\OrderRepositoryInterface $subject,
         $resultOrder
    ) {

        $extensionAttributes = $resultOrder->getExtensionAttributes();

        if (null !== $extensionAttributes && null !== $extensionAttributes->getPostcode()) {
            $resultOrder->setPostcode($extensionAttributes->getPostcode());
        }

        return [$resultOrder];

    }
    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $searchResult
     * @return OrderSearchResultInterface
     */
    public function afterGetList(OrderRepositoryInterface $subject, OrderSearchResultInterface $searchResult): OrderSearchResultInterface
    {
        $orders = $searchResult->getItems();
        foreach ($orders as &$order) {
            $order = $this->afterGet($subject, $order);
        }
        return $searchResult;
    }
}
