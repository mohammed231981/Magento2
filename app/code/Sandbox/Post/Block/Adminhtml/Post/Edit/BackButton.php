<?php declare(strict_types = 1);

namespace Sandbox\Post\Block\Adminhtml\Post\Edit;

use Magento\Framework\Phrase;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class BackButton
 */
class BackButton extends \Magento\Backend\Block\Template implements ButtonProviderInterface
{
    /**
     * @return array[][]
     */
    public function getButtonData(): array
    {
        return [
            'label' => new Phrase('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10,
        ];
    }

    /**
     * @return string
     */
    public function getBackUrl(): string
    {
        return $this->getUrl('*/*/');
    }
}
