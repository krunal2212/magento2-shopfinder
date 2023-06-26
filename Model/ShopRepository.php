<?php
/**
 * Levelshoes_Shopfinder extension
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category  Levelshoes
 * @package   Levelshoes_Shopfinder
 * @copyright Copyright (c) 2023
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 */
namespace Levelshoes\Shopfinder\Model;

use Levelshoes\Shopfinder\Api\Data\ShopInterface;
use Levelshoes\Shopfinder\Api\Data\ShopInterfaceFactory;
use Levelshoes\Shopfinder\Api\Data\ShopSearchResultInterfaceFactory;
use Levelshoes\Shopfinder\Api\ShopRepositoryInterface;
use Levelshoes\Shopfinder\Model\ResourceModel\Shop as ShopResourceModel;
use Levelshoes\Shopfinder\Model\ResourceModel\Shop\Collection;
use Levelshoes\Shopfinder\Model\ResourceModel\Shop\CollectionFactory as ShopCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;

class ShopRepository implements ShopRepositoryInterface
{
    /**
     * Cached instances
     * 
     * @var array
     */
    protected $instances = [];

    /**
     * Shop resource model
     * 
     * @var ShopResourceModel
     */
    protected $resource;

    /**
     * Shop collection factory
     * 
     * @var ShopCollectionFactory
     */
    protected $shopCollectionFactory;

    /**
     * Shop interface factory
     * 
     * @var ShopInterfaceFactory
     */
    protected $shopInterfaceFactory;

    /**
     * Data Object Helper
     * 
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * Search result factory
     * 
     * @var ShopSearchResultInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * constructor
     * 
     * @param ShopResourceModel $resource
     * @param ShopCollectionFactory $shopCollectionFactory
     * @param ShopInterfaceFactory $shopInterfaceFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param ShopSearchResultInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        ShopResourceModel $resource,
        ShopCollectionFactory $shopCollectionFactory,
        ShopInterfaceFactory $shopInterfaceFactory,
        DataObjectHelper $dataObjectHelper,
        ShopSearchResultInterfaceFactory $searchResultsFactory
    ) {
        $this->resource              = $resource;
        $this->shopCollectionFactory = $shopCollectionFactory;
        $this->shopInterfaceFactory  = $shopInterfaceFactory;
        $this->dataObjectHelper      = $dataObjectHelper;
        $this->searchResultsFactory  = $searchResultsFactory;
    }

    /**
     * Save Shop.
     *
     * @param \Levelshoes\Shopfinder\Api\Data\ShopInterface $shop
     * @return \Levelshoes\Shopfinder\Api\Data\ShopInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(ShopInterface $shop)
    {
        /** @var ShopInterface|\Magento\Framework\Model\AbstractModel $shop */
        try {
            $this->resource->save($shop);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Shop: %1',
                $exception->getMessage()
            ));
        }
        return $shop;
    }

    /**
     * Retrieve Shop.
     *
     * @param int $shopId
     * @return \Levelshoes\Shopfinder\Api\Data\ShopInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($shopId)
    {
        if (!isset($this->instances[$shopId])) {
            /** @var ShopInterface|\Magento\Framework\Model\AbstractModel $shop */
            $shop = $this->shopInterfaceFactory->create();
            $this->resource->load($shop, $shopId);
            if (!$shop->getId()) {
                throw new NoSuchEntityException(__('Requested Shop doesn\'t exist'));
            }
            $this->instances[$shopId] = $shop;
        }
        return $this->instances[$shopId];
    }

    /**
     * Retrieve Finders matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Levelshoes\Shopfinder\Api\Data\ShopSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Levelshoes\Shopfinder\Api\Data\ShopSearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var \Levelshoes\Shopfinder\Model\ResourceModel\Shop\Collection $collection */
        $collection = $this->shopCollectionFactory->create();

        //Add filters from root filter group to the collection
        /** @var \Magento\Framework\Api\Search\FilterGroup $group */
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
        $sortOrders = $searchCriteria->getSortOrders();
        /** @var SortOrder $sortOrder */
        if ($sortOrders) {
            foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                $field = $sortOrder->getField();
                $collection->addOrder(
                    $field,
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        } else {
            // set a default sorting order since this method is used constantly in many
            // different blocks
            $field = 'shop_id';
            $collection->addOrder($field, 'ASC');
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        /** @var ShopInterface[] $finders */
        $finders = [];
        /** @var \Levelshoes\Shopfinder\Model\Shop $shop */
        foreach ($collection as $shop) {
            /** @var ShopInterface $shopDataObject */
            $shopDataObject = $this->shopInterfaceFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $shopDataObject,
                $shop->getData(),
                ShopInterface::class
            );
            $finders[] = $shopDataObject;
        }
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults->setItems($finders);
    }

    /**
     * Delete Shop.
     *
     * @param ShopInterface $shop
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(ShopInterface $shop)
    {
        /** @var ShopInterface|\Magento\Framework\Model\AbstractModel $shop */
        $id = $shop->getId();
        try {
            unset($this->instances[$id]);
            $this->resource->delete($shop);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove Shop %1', $id)
            );
        }
        unset($this->instances[$id]);
        return true;
    }

    /**
     * Delete Shop by ID.
     *
     * @param int $shopId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($shopId)
    {
        $shop = $this->getById($shopId);
        return $this->delete($shop);
    }

    /**
     * Helper function that adds a FilterGroup to the collection.
     *
     * @param FilterGroup $filterGroup
     * @param Collection $collection
     * @return $this
     * @throws \Magento\Framework\Exception\InputException
     */
    protected function addFilterGroupToCollection(
        FilterGroup $filterGroup,
        Collection $collection
    ) {
        $fields = [];
        $conditions = [];
        foreach ($filterGroup->getFilters() as $filter) {
            $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
            $fields[] = $filter->getField();
            $conditions[] = [$condition => $filter->getValue()];
        }
        if ($fields) {
            $collection->addFieldToFilter($fields, $conditions);
        }
        return $this;
    }
}
