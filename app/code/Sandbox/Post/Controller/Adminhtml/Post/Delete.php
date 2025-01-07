<?php declare(strict_types = 1);

namespace Sandbox\Post\Controller\Adminhtml\Post;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Phrase;
use Sandbox\Post\Api\PostRepositoryInterface;

/**
 * Class Delete
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Sandbox\Post\Api\PostRepositoryInterface
     */
    protected $repository;

    /**
     * Delete constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Sandbox\Post\Api\PostRepositoryInterface $repository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        PostRepositoryInterface $repository
    ) {
        parent::__construct($context);
        $this->repository = $repository;
    }

    /**
     * @return bool
     */
    public function _isAllowed(): bool //phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        return $this->_authorization->isAllowed('Sandbox_Post::post_view');
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $postId = $this->getRequest()->getParam('entity_id');

        try {
            $post = $this->repository->getById((int) $postId);
            $this->repository->delete($post);

            $this->messageManager->addSuccessMessage('Post has been deleted successfully.');
        } catch (\RuntimeException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Throwable $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->messageManager->addExceptionMessage(
                $e,
                new Phrase('Something went wrong while deleting the post.')
            );
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->getUrl('sandbox/post/index'));

        return $resultRedirect;
    }
}
