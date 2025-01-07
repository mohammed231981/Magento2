<?php declare(strict_types = 1);

namespace Sandbox\Post\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Sandbox\Post\Api\Data\PostInterface;
use Sandbox\Post\Api\Data\PostSearchResultInterface;

/**
 * Interface PostRepositoryInterface
 */
interface PostRepositoryInterface
{
    /**
     * @param int $id
     * @return \Sandbox\Post\Api\Data\PostInterface
     */
    public function getById(int $id): PostInterface;

    /**
     * @param \Sandbox\Post\Api\Data\PostInterface $post
     * @return \Sandbox\Post\Api\Data\PostInterface
     */
    public function save(PostInterface $post): PostInterface;

    /**
     * @param \Sandbox\Post\Api\Data\PostInterface $post
     * @return void
     */
    public function delete(PostInterface $post): void;

    /**
     * @param int $id
     * @return void
     */
    public function deleteById(int $id): void;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Sandbox\Post\Api\Data\PostSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): PostSearchResultInterface;
}
