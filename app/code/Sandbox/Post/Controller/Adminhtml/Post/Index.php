<?php declare(strict_types = 1);

namespace Sandbox\Post\Controller\Adminhtml\Post;

use Magento\Framework\Phrase;

/**
 * Class Index
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param \Magento\Backend\App\Action\Context        $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
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
        return $this->_authorization->isAllowed('Sandbox_Post::post_view');
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute(): \Magento\Backend\Model\View\Result\Page
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Sandbox_Post::post_view'
        )->addBreadcrumb(
            new Phrase('Post'),
            new Phrase('Post')
        )->addBreadcrumb(
            new Phrase('Manage Post'),
            new Phrase('Manage Post')
        );
        $resultPage->getConfig()->getTitle()->prepend(new Phrase('Post'));

        return $resultPage;
    }
}
