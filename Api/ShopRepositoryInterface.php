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
namespace Levelshoes\Shopfinder\Api;

use Levelshoes\Shopfinder\Api\Data\ShopInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * @api
 */
interface ShopRepositoryInterface
{
    /**
     * Save Shop.
     *
     * @param \Levelshoes\Shopfinder\Api\Data\ShopInterface $shop
     * @return \Levelshoes\Shopfinder\Api\Data\ShopInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(ShopInterface $shop);

    /**
     * Retrieve Shop
     *
     * @param int $shopId
     * @return \Levelshoes\Shopfinder\Api\Data\ShopInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($shopId);

    /**
     * Retrieve Finders matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Levelshoes\Shopfinder\Api\Data\ShopSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Shop.
     *
     * @param \Levelshoes\Shopfinder\Api\Data\ShopInterface $shop
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(ShopInterface $shop);

    /**
     * Delete Shop by ID.
     *
     * @param int $shopId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($shopId);
}
