<?php declare(strict_types = 1);

namespace Sandbox\Post\Controller\Adminhtml\Post;

use Magento\Framework\Phrase;

/**
 * Class NewAction
 */
class NewAction extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * NewAction constructor.
     *
     * @param \Magento\Backend\App\Action\Context        $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry                $registry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return bool
     */
    public function _isAllowed(): bool //phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        return $this->_authorization->isAllowed('Sandbox_Post::post_save');
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect|\Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
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
                new Phrase('New Post'),
                new Phrase('New Post')
            );

        $resultPage->getConfig()->getTitle()->prepend(new Phrase('New Post'));

        return $resultPage;
    }
}
