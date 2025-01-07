<?php declare(strict_types = 1);

namespace Sandbox\Post\Model;

use Magento\Framework\Api\SearchResults;
use Magento\Framework\Api\SearchResultsInterface;
use Sandbox\Post\Api\Data\PostSearchResultInterface;

/**
 * Class PostSearchResult
 */
class PostSearchResult extends SearchResults implements PostSearchResultInterface
{
    /**
     * @return \Magento\Framework\Api\AbstractExtensibleObject[]
     */
    public function getItems(): array
    {
        return parent::getItems();
    }

    /**
     * @param \Magento\Framework\Api\AbstractExtensibleObject[] $items
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function setItems(array $items): SearchResultsInterface
    {
        return parent::setItems($items);
    }
}
