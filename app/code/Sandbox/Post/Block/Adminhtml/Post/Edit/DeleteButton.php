<?php declare(strict_types = 1);

namespace  Sandbox\Post\Block\Adminhtml\Post\Edit;

use Magento\Framework\Phrase;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class DeleteButton
 */
class DeleteButton extends \Magento\Backend\Block\Template implements ButtonProviderInterface
{
    /**
     * @return array[][]
     */
    public function getButtonData(): array
    {
        return [
            'id' => 'delete',
            'label' => new Phrase('Delete'),
            'on_click' => 'deleteConfirm(' . json_encode((string)(new Phrase('Are you sure you want to do this?')))
                . ','
                . json_encode($this->getDeleteUrl())
                . ')',
            'class' => 'delete',
            'sort_order' => 15,
        ];
    }

    /**
     * @param array[][] $args
     * @return string
     */
    public function getDeleteUrl(array $args = []): string
    {
        $params = array_merge($this->getDefaultUrlParams(), $args);

        return $this->getUrl('sandbox/post/delete', $params);
    }

    /**
     * @return array[][]
     */
    protected function getDefaultUrlParams(): array
    {
        return ['_current' => true, '_query' => ['isAjax' => null]];
    }
}
