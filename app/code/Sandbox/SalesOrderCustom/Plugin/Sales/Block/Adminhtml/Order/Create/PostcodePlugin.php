<?php declare(strict_types = 1);

namespace Sandbox\SalesOrderCustom\Plugin\Sales\Block\Adminhtml\Order\Create;

use Magento\Sales\Block\Adminhtml\Order\Create\Data;

/**
 * Class PostcodePlugin
 * @package Sandbox\SalesOrderCustom\Plugin\Sales\Block\Adminhtml\Order\View
 */
class PostcodePlugin
{

    /**
     * @param Data $subject
     * @param callable $proceed
     * @param string $id
     * @param bool $useCache
     * @return string
     */
    public function aroundGetChildHtml(Data $subject, callable $proceed, string $id, $useCache = true): string
    {

        $html = $proceed($id, $useCache);

        if ($id == 'form_account') {
            $block = $subject->getChildHtml('postcode_section');
            $html = $html . $block;
        }

        return $html;
    }
}
