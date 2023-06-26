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
namespace Levelshoes\Shopfinder\Block\Adminhtml\Shop\Edit\Buttons;

use Levelshoes\Shopfinder\Api\ShopRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

class Generic
{
    /**
     * Widget Context
     * 
     * @var Context
     */
    protected $context;

    /**
     * Shop Repository
     * 
     * @var ShopRepositoryInterface
     */
    protected $shopRepository;

    /**
     * constructor
     * 
     * @param Context $context
     * @param ShopRepositoryInterface $shopRepository
     */
    public function __construct(
        Context $context,
        ShopRepositoryInterface $shopRepository
    ) {
        $this->context        = $context;
        $this->shopRepository = $shopRepository;
    }

    /**
     * Return Shop ID
     *
     * @return int|null
     */
    public function getShopId()
    {
        try {
            return $this->shopRepository->getById(
                $this->context->getRequest()->getParam('shop_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
