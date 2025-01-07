<?php declare(strict_types = 1);

namespace Sandbox\Post\Model\ResourceModel\Post;

use Sandbox\Post\Model\Post;

/**
 * Class Collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(Post::class, \Sandbox\Post\Model\ResourceModel\Post::class);
    }
}
