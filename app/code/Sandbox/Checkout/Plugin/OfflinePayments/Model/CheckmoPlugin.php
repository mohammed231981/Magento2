<?php declare(strict_types = 1);

namespace Sandbox\Checkout\Plugin\OfflinePayments\Model;

use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;

/**
 * Class CheckmoPlugin
 */
class CheckmoPlugin
{

    protected State $state;

    protected SessionFactory $customerSessionFactory;

    /**
     * CashondeliveryPlugin constructor.
     *
     * @param \Magento\Framework\App\State        $state
     */
    public function __construct(
        State $state,
        SessionFactory $customerSessionFactory
    ) {
        $this->state = $state;
        $this->customerSessionFactory = $customerSessionFactory;
    }

    /**
     * @param \Magento\OfflinePayments\Model\Checkmo $subject
     * @param callable                                      $proceed
     * @param \Magento\Quote\Api\Data\CartInterface|null    $quote
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function aroundIsAvailable(
        \Magento\OfflinePayments\Model\Checkmo $subject,
        callable $proceed,
        \Magento\Quote\Api\Data\CartInterface $quote = null
    ): bool {
        if (Area::AREA_ADMINHTML === $this->state->getAreaCode()) {
            return $proceed($quote);
        }

        $customer = $this->customerSessionFactory->create();
        if (null === $quote || !$customer->isLoggedIn()) {
            return false;
        }

        return $proceed($quote);
    }
}
