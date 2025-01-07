<?php declare(strict_types = 1);


namespace Sandbox\Post\Ui\DataProvider;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Registry;
use Sandbox\Post\Model\PostRepository;
use Sandbox\Post\Model\ResourceModel\Post\CollectionFactory;

/**
 * Class postFormDataProvider
 *
 */
class PostFormDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \Sandbox\Post\Model\PostRepository
     */
    protected $postRepository;

    /**
     * FormDataProvider constructor.
     *
     * @param string                                                     $name
     * @param string                                                     $primaryFieldName
     * @param string                                                     $requestFieldName
     * @param \Sandbox\Post\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory
     * @param \Magento\Framework\Registry                                $registry
     * @param \Magento\Framework\App\RequestInterface                    $request
     * @param \Sandbox\Post\Model\PostRepository                       $postRepository
     * @param array[][]                                                  $meta
     * @param array[][]                                                  $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $postCollectionFactory,
        Registry $registry,
        RequestInterface $request,
        PostRepository $postRepository,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $postCollectionFactory->create();
        $this->registry = $registry;
        $this->request = $request;
        $this->postRepository = $postRepository;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array[][]
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $post= $this->getCurrentPost();

        if ($post) {
            $postData = $post->getData();
            $this->loadedData[$post->getId()] = $postData;
        }

        if (empty($post)) {
            $block = $this->collection->getNewEmptyItem();
            $block->setData($post);
            $postData = $block->getData();
            $this->loadedData[$block->getId()] = $postData;
        }

        return $this->loadedData;
    }

    /**
     * @return mixed|\Sandbox\Post\Model\Post|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCurrentPost()
    {
        $post = $this->registry->registry('current_post');

        if ($post) {
            return $post;
        }

        $requestId = $this->request->getParam($this->requestFieldName);

        if ($requestId) {
            $post = $this->postRepository->getById((int)$requestId);
        }

        return $post;
    }


}
