<?php declare(strict_types = 1);

namespace Sandbox\Post\Model;


use Sandbox\Post\Component\Model\TypedDataObjectTrait;

/**
 * Class Post
 */
class Post extends \Magento\Framework\Model\AbstractModel implements \Sandbox\Post\Api\Data\PostInterface
{
    use TypedDataObjectTrait;

    public const DB_SANDBOX_POST = 'sandbox_post';

    public const ENTITY_ID = 'entity_id';
    public const TITLE = 'title';
    public const DESCRIPTION = 'description';


    /**
     * Post constructor.
     *
     * @param \Magento\Framework\Model\Context                             $context
     * @param \Magento\Framework\Registry                                  $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null           $resourceCollection
     * @param array[][]                                                    $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        ?\Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        ?\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }


    protected function _construct(): void //phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        $this->_init(\Sandbox\Post\Model\ResourceModel\Post::class);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->getIdTyped($this);
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->getDataString($this, self::TITLE);
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->setData(self::TITLE, $title);
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->getDataString($this, self::DESCRIPTION);
    }

    /**
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->setData(self::DESCRIPTION, $description);
    }
}
