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

namespace Levelshoes\Shopfinder\Model\Resolver;

use Levelshoes\Shopfinder\Model\ResourceModel\Shop\CollectionFactory as ShopCollectionFactory;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class ListShopsByStoreIDGraphql implements ResolverInterface
{

    protected $shopCollection;


    public function __construct(
        ShopCollectionFactory $shopCollection
    )
    {
        $this->shopCollection = $shopCollection;
    }


    /**
     * @param Field $field
     * @param \Magento\Framework\GraphQl\Query\Resolver\ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|\Magento\Framework\GraphQl\Query\Resolver\Value|mixed
     * @throws GraphQlInputException
     */
    public function resolve(
        Field       $field,
                    $context,
        ResolveInfo $info,
        array       $value = null,
        array       $args = null)
    {


        if (empty($args) || empty($args['shop_id'])) {
            throw new GraphQlNoSuchEntityException(
                __('Please enter the shop_id to get the data'));
        }

        $shopId = $args['shop_id'];
        $collection = $this->shopCollection->create()
            ->addFieldToFilter('shop_id', $shopId)->setPageSize(1);
        if ($collection->getSize() > 0) {
            return $collection->getFirstItem();
        } else {
            throw new GraphQlNoSuchEntityException(
                __('Shop Data with shop id %1 not found', $shopId));
        }
    }
}
