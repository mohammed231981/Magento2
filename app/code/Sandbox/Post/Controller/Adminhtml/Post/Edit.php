<?php declare(strict_types = 1);

namespace Sandbox\Post\Controller\Adminhtml\Post;

use Magento\Framework\Phrase;

/**
 * Class Edit
 */
class Edit extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Sandbox\Post\Model\Post
     */
    protected $post;

    /**
     * Edit constructor.
     *
     * @param \Magento\Backend\App\Action\Context        $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry                $registry
     * @param \Sandbox\Post\Model\Post                  $post
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Sandbox\Post\Model\Post $post
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $registry;
        $this->post = $post;
        parent::__construct($context);
    }


    /**
     * @return \Magento\Framework\Controller\Result\Redirect|\Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');

        if ($id) {
            $post = $this->post->load($id);

            if (!$post->getId()) {
                $this->messageManager->addError(new Phrase('This Post no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }

            $this->coreRegistry->register('current_post', $post);

            /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
            $resultPage = $this->resultPageFactory->create();
            $resultPage->setActiveMenu(
                'Sandbox_Post::post_view'
            );
            $resultPage
                ->addBreadcrumb(
                    new Phrase('Post'),
                    new Phrase('Post')
                )
                ->addBreadcrumb(
                    new Phrase('Manage Post'),
                    new Phrase('Manage Post')
                )
                ->addBreadcrumb(
                    new Phrase('Edit Post'),
                    new Phrase('Edit Post')
                );

            $resultPage->getConfig()->getTitle()->prepend($post->getTitle());

            return $resultPage;
        }

        $this->messageManager->addError(new Phrase('Error Loading Post.'));
        /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
