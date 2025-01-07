<?php declare(strict_types = 1);

namespace Sandbox\CatalogInventory\Setup;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;


/**
 * Class UpgradeData
 *
 */
class UpgradeData implements UpgradeDataInterface
{

    private \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory;

    protected \Magento\Framework\App\ResourceConnection $resourceConnection;

    /**
     * UpgradeData constructor.
     *
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     * @param \Magento\Framework\App\ResourceConnection $resourceConnection
     */
    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Framework\App\ResourceConnection $resourceConnection
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface   $context
     * @return void
     */
    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ): void {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.0', '<')) {

            /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create();

            try {
                $eavSetup->addAttribute(
                    \Magento\Catalog\Model\Product::ENTITY,
                    'order_product_quickly',
                    [
                        'group' => 'General',
                        'type' => 'int',
                        'label' => 'Order product quickly',
                        'input' => 'text',
                        'source' => '',
                        'frontend_class' => 'validate-greater-than-zero validate-number',
                        'frontend' => '',
                        'required' => false,
                        'sort_order' => 50,
                        'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                        'is_used_in_grid' => false,
                        'is_visible_in_grid' => false,
                        'is_filterable_in_grid' => true,
                        'is_searchable' => false,
                        'is_comparable' => false,
                        'is_filterable' => false,
                        'visible' => true,
                        'is_html_allowed_on_front' => true,
                        'visible_on_front' => false,
                    ]
                );
            } catch (LocalizedException | \Zend_Validate_Exception $e) {
                echo $e->getMessage();
            }
        }
    }
}
