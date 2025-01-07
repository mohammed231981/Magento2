<?php declare(strict_types = 1);

namespace  Sandbox\Post\Block\Adminhtml\Post\Edit;

use Magento\Framework\Phrase;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveButton
 */
class SaveButton extends \Magento\Backend\Block\Template implements ButtonProviderInterface
{
    /**
     * @return array[][]
     */
    public function getButtonData(): array
    {
        return [
            'label' => new Phrase('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 40,
        ];
    }
}
