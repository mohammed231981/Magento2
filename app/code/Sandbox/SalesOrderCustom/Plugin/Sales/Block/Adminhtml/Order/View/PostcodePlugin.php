<?php declare(strict_types = 1);

namespace Sandbox\SalesOrderCustom\Plugin\Sales\Block\Adminhtml\Order\View;

use Magento\Sales\Block\Adminhtml\Order\Create\Data;

/**
 * Class PostcodePlugin
 * @package Sandbox\SalesOrderCustom\Plugin\Sales\Block\Adminhtml\Order\View
 */
class PostcodePlugin
{

    /**
     * @param \Magento\Sales\Block\Adminhtml\Order\View\Info $subject
     * @param string $result
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterToHtml(
        \Magento\Sales\Block\Adminhtml\Order\View\Info $subject,
        string $result
    ): string {
        $postcodeBlock = $subject->getLayout()->getBlock('custom_order_postcode');
        $order = $subject->getOrder();
        $orderPostcode = $order->getExtensionAttributes()->getPostcode();

        if (
            false !== $postcodeBlock
            && 'order_info' === $subject->getNameInLayout()
            && $orderPostcode
        ){
            $postcodeBlock->setPostcode($orderPostcode);
            $result .= $postcodeBlock->toHtml();
        }

        return $result;
    }
}
