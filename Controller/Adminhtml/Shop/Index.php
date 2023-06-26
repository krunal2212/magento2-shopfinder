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

class Index extends ShopController
{
    /**
     * Finders list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Levelshoes_Shopfinder::shop');
        $resultPage->getConfig()->getTitle()->prepend(__('Shop Finder'));
        $resultPage->addBreadcrumb(__('Shop Finder'), __('Shop Finder'));
        $resultPage->addBreadcrumb(__('Shop Finder'), __('Shop Finder'));
        return $resultPage;
    }
}
