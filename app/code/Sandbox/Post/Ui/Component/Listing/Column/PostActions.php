<?php declare(strict_types = 1);

namespace Sandbox\Post\Ui\Component\Listing\Column;

use Magento\Framework\Phrase;

/**
 * Class PostActions
 */
class PostActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    public const URL_PATH_EDIT = 'sandbox/post/edit';
    public const URL_PATH_DELETE = 'sandbox/post/delete';

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    /**
     * PostActions constructor.
     *
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory           $uiComponentFactory
     * @param \Magento\Framework\UrlInterface                              $urlBuilder
     * @param array[][]                                                    $components
     * @param array[][]                                                    $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array[][] $dataSource
     * @return array[][]
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            if (!isset($item['entity_id'])) {
                continue;
            }

            $item[$this->getData('name')] = [
                'edit' => [
                    'href' => $this->urlBuilder->getUrl(
                        self::URL_PATH_EDIT,
                        [
                            'entity_id' => $item['entity_id'],
                        ]
                    ),
                    'label' => new Phrase('Edit'),
                ],
                'delete' => [
                    'href' => $this->urlBuilder->getUrl(
                        self::URL_PATH_DELETE,
                        [
                            'entity_id' => $item['entity_id'],
                        ]
                    ),
                    'label' => new Phrase('Delete'),
                    'confirm' => [
                        'title' => new Phrase('Delete "${ $.$data.name }"'),
                        'message' => new Phrase('Are you sure you wan\'t to delete a "${ $.$data.name }" record?'),
                    ],
                ],
            ];
        }

        return $dataSource;
    }
}
