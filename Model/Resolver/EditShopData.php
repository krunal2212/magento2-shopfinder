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
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\GraphQl\Model\Query\ContextInterface;

class EditShopData implements ResolverInterface
{

    /**
     * @param \Levelshoes\Shopfinder\Model\Shop $shopModel
     * @param ShopCollectionFactory $shopCollection
     */
    public function __construct(
        \Levelshoes\Shopfinder\Model\Shop $shopModel,
        ShopCollectionFactory             $shopCollection
    )
    {
        $this->shopModel = $shopModel;
        $this->shopCollection = $shopCollection;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field       $field,
                    $context,
        ResolveInfo $info,
        array       $value = null,
        array       $args = null
    )
    {
        try {
            /** @var ContextInterface $context */

            if (empty($args)) {
                return [
                    'status' => false,
                    'message' => __('Please enter the valid data to update')
                ];
            } else if (empty($args['shop_id'])) {
                return [
                    'status' => false,
                    'message' => __('Please enter valid shopId')
                ];
            }

            $shopId = $args['shop_id'];

            unset($args['shopimage']); // Shop Image will not be updated

            $collection = $this->shopCollection->create()
                ->addFieldToFilter('shop_id', $shopId);
            if ($collection->getSize() > 0) {
                $model = $this->shopModel;
                $model->load($shopId);
                $model->setData($args);
                $model->save();
                return [
                    'status' => true,
                    'message' => __('Your Data Saved Successfully')
                ];
            } else {
                throw new GraphQlNoSuchEntityException(
                    __('Shop Data with shop id %1 not found', $shopId));
            }
        } catch (NoSuchEntityException $exception) {
            throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
        } catch (LocalizedException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()));
        }
    }
}
