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
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class Delete extends ShopController
{
    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('shop_id');
        if ($id) {
            try {
                $this->shopRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('The Shop has been deleted.'));
                $resultRedirect->setPath('levelshoes_shopfinder/*/');
                return $resultRedirect;
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('The Shop no longer exists.'));
                return $resultRedirect->setPath('levelshoes_shopfinder/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('levelshoes_shopfinder/shop/edit', ['shop_id' => $id]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('There was a problem deleting the Shop'));
                return $resultRedirect->setPath('levelshoes_shopfinder/shop/edit', ['shop_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a Shop to delete.'));
        $resultRedirect->setPath('levelshoes_shopfinder/*/');
        return $resultRedirect;
    }
}
