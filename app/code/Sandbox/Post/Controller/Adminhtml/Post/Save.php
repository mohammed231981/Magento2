<?php declare(strict_types = 1);

namespace Sandbox\Post\Controller\Adminhtml\Post;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Phrase;
use Psr\Log\LoggerInterface;
use Sandbox\Post\Api\PostRepositoryInterface as PostRepository;

/**
 * Class Save
 *
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \Sandbox\Post\Model\PostFactory
     */
    protected $postFactory;

    /**
     * @var PostRepository
     */
    protected $repository;

    /**
     * Save constructor.
     *
     * @param \Magento\Backend\App\Action\Context  $context
     * @param \Sandbox\Post\Model\PostFactory    $postFactory
     * @param \Psr\Log\LoggerInterface             $logger
     * @param PostRepository $repository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Sandbox\Post\Model\PostFactory $postFactory,
        LoggerInterface $logger,
        PostRepository $repository
    ) {
        parent::__construct($context);

        $this->postFactory = $postFactory;
        $this->logger = $logger;
        $this->repository = $repository;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $postId = $this->getRequest()->getParam('entity_id');

        try {
            if ($postId) {
                $post = $this->repository->getById((int)$postId);
                $post->setDescription($data['description']);
                $post->setTitle($data['title']);

                $this->repository->save($post);

                $this->messageManager->addSuccessMessage('Post has been saved successfully.');

                $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setUrl($this->getUrl('sandbox/post/index'));

                return $resultRedirect;
            }

            /**
             * @var \Sandbox\Post\Model\Post $post
             */
            $post = $this->postFactory->create();
            unset($data['entity_id']);
            $post->setData($data);

            $this->repository->save($post);

            $this->messageManager->addSuccessMessage('Post has been saved successfully.');
        } catch (\RuntimeException $e) {
            $this->logger->critical($e->getMessage(), ['error' => $e]);
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Throwable $e) {
            $this->logger->critical($e->getMessage(), ['error' => $e]);
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->messageManager->addExceptionMessage(
                $e,
                new Phrase('Something went wrong while saving the Post.')
            );
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->getUrl('sandbox/post/index'));

        return $resultRedirect;
    }
}
