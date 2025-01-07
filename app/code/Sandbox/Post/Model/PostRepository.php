<?php declare(strict_types = 1);

namespace Sandbox\Post\Model;

use Magento\Framework\Api\Search\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Phrase;
use Sandbox\Post\Api\Data\PostInterface;
use Sandbox\Post\Api\Data\PostSearchResultInterface;
use Sandbox\Post\Api\Data\PostSearchResultInterfaceFactory;
use Sandbox\Post\Api\PostRepositoryInterface;
use Sandbox\Post\Model\ResourceModel\Post as PostResource;
use Sandbox\Post\Model\ResourceModel\Post\Collection;
use Sandbox\Post\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;

/**
 * Class PostRepository
 */
class PostRepository implements PostRepositoryInterface
{
    /**
     * @var \Sandbox\Post\Model\ResourceModel\Post
     */
    protected $resource;

    /**
     * @var \Sandbox\Post\Model\PostFactory
     */
    protected $postFactory;

    /**
     * @var \Sandbox\Post\Model\ResourceModel\Post\CollectionFactory
     */
    protected $postCollectionFactory;

    /**
     * @var \Sandbox\Post\Api\Data\PostSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @var \Sandbox\Post\Model\ResourceModel\Post\Collection
     */
    protected $allPosts;

    /**
     * PostRepository constructor.
     *
     * @param \Sandbox\Post\Model\ResourceModel\Post                   $resource
     * @param \Sandbox\Post\Model\PostFactory                          $postFactory
     * @param \Sandbox\Post\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory
     * @param \Sandbox\Post\Api\Data\PostSearchResultInterfaceFactory $postSearchResultInterfaceFactory
     */
    public function __construct(
        PostResource $resource,
        PostFactory $postFactory,
        PostCollectionFactory $postCollectionFactory,
        PostSearchResultInterfaceFactory $postSearchResultInterfaceFactory
    ) {
        $this->resource = $resource;
        $this->postFactory = $postFactory;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->searchResultFactory = $postSearchResultInterfaceFactory;
    }

    /**
     * @param int $id
     * @return \Sandbox\Post\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): PostInterface
    {
        /** @var \Sandbox\Post\Model\Post $post */
        $post = $this->postFactory->create();

        $post = $this->allPosts && $this->allPosts->isLoaded()
            ? $this->allPosts->getItemById($id)
            : $post;

        if (!$post->getId()) {
            $this->resource->load($post, $id);
        }

        if (!$post || !$post->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                new Phrase('Unable to find post with ID "%1"', [$id])
            );
        }

        return $post;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Sandbox\Post\Api\Data\PostSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): PostSearchResultInterface
    {
        /** @var \Sandbox\Post\Model\ResourceModel\Post\Collection $collection */
        $collection = $this->postCollectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * @return \Sandbox\Post\Api\Data\PostSearchResultInterface
     */
    public function getAll(): PostSearchResultInterface
    {
        if (null === $this->allPosts) {

            /** @var \Sandbox\Post\Model\ResourceModel\Post\Collection $collection */
            $this->allPosts = $this->postCollectionFactory->create();
        }

        /** @var \Sandbox\Post\Model\PostSearchResult $searchResults */
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria(new SearchCriteria());
        $searchResults->setItems($this->allPosts->getItems());
        $searchResults->setTotalCount(count($this->allPosts->getItems()));

        return $searchResults;
    }

    /**
     * @param \Sandbox\Post\Api\Data\PostInterface $post
     * @return \Sandbox\Post\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(PostInterface $post): PostInterface
    {
        $this->resource->save($post);

        return $post;
    }

    /**
     * @param \Sandbox\Post\Api\Data\PostInterface $post
     * @return void
     * @throws \Exception
     */
    public function delete(PostInterface $post): void
    {
        $this->resource->delete($post);
    }

    /**
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public function deleteById(int $id): void
    {
        $post = $this->getById($id);
        $this->delete($post);
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface      $searchCriteria
     * @param \Sandbox\Post\Model\ResourceModel\Post\Collection $collection
     * @return void
     */
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection): void
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];

            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }

            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface      $searchCriteria
     * @param \Sandbox\Post\Model\ResourceModel\Post\Collection $collection
     * @return void
     */
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection): void
    {
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $direction = SortOrder::SORT_ASC === $sortOrder->getDirection()
                ? 'asc'
                : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface      $searchCriteria
     * @param \Sandbox\Post\Model\ResourceModel\Post\Collection $collection
     * @return void
     */
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection): void
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface      $searchCriteria
     * @param \Sandbox\Post\Model\ResourceModel\Post\Collection $collection
     * @return \Sandbox\Post\Api\Data\PostSearchResultInterface
     */
    private function buildSearchResult(
        SearchCriteriaInterface $searchCriteria,
        Collection $collection
    ): PostSearchResultInterface {
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
