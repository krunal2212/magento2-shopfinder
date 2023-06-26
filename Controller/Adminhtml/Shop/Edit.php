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
namespace Levelshoes\Shopfinder\Controller\Adminhtml\Shop;

use Levelshoes\Shopfinder\Controller\Adminhtml\Shop as ShopController;
use Levelshoes\Shopfinder\Controller\RegistryConstants;

class Edit extends ShopController
{
    /**
     * Initialize current Shop and set it in the registry.
     *
     * @return int
     */
    protected function initShop()
    {
        $shopId = $this->getRequest()->getParam('shop_id');
        $this->coreRegistry->register(RegistryConstants::CURRENT_SHOP_ID, $shopId);

        return $shopId;
    }

    /**
     * Edit or create Shop
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $shopId = $this->initShop();

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Levelshoes_Shopfinder::shopfinder_shop');
        $resultPage->getConfig()->getTitle()->prepend(__('Finders'));
        $resultPage->addBreadcrumb(__('Shop Finder'), __('Shop Finder'));
        $resultPage->addBreadcrumb(__('Finders'), __('Finders'), $this->getUrl('levelshoes_shopfinder/shop'));

        if ($shopId === null) {
            $resultPage->addBreadcrumb(__('New Shop'), __('New Shop'));
            $resultPage->getConfig()->getTitle()->prepend(__('New Shop'));
        } else {
            $resultPage->addBreadcrumb(__('Edit Shop'), __('Edit Shop'));
            $resultPage->getConfig()->getTitle()->prepend(
                $this->shopRepository->getById($shopId)->getShopname()
            );
        }
        return $resultPage;
    }
}
