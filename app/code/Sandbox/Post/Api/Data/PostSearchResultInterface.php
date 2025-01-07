<?php declare(strict_types = 1);

namespace Sandbox\Post\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface \Sandbox\Post\Api\Data\PostSearchResultInterface
 */
interface PostSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Sandbox\Post\Api\Data\PostInterface[]
     */
    public function getItems(): array;

    /**
     * @param \Sandbox\Post\Api\Data\PostInterface[] $items
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function setItems(array $items): SearchResultsInterface;
}
