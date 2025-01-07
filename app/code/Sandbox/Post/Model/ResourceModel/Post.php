<?php declare(strict_types = 1);

namespace Sandbox\Post\Model\ResourceModel;

use Sandbox\Post\Model\Post as PostModel;

/**
 * Class Post
 */
class Post extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Post constructor.
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param string|null                                       $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        ?string $connectionName = null
    ) {
        parent::__construct($context, $connectionName);

    }

    protected function _construct(): void //phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        $this->_init(
            PostModel::DB_SANDBOX_POST,
            PostModel::ENTITY_ID
        );
    }


}
