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

use Levelshoes\Shopfinder\Api\Data\ShopInterface;
use Levelshoes\Shopfinder\Api\Data\ShopInterfaceFactory;
use Levelshoes\Shopfinder\Api\ShopRepositoryInterface;
use Levelshoes\Shopfinder\Controller\Adminhtml\Shop as ShopController;
use Levelshoes\Shopfinder\Model\UploaderPool;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Save extends ShopController
{
    /**
     * Shop factory
     * 
     * @var ShopInterfaceFactory
     */
    protected $shopFactory;

    /**
     * Data Object Processor
     * 
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * Data Object Helper
     * 
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * Uploader pool
     * 
     * @var UploaderPool
     */
    protected $uploaderPool;

    /**
     * Data Persistor
     * 
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * constructor
     * 
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ShopRepositoryInterface $shopRepository
     * @param PageFactory $resultPageFactory
     * @param ShopInterfaceFactory $shopFactory
     * @param DataObjectProcessor $dataObjectProcessor
     * @param DataObjectHelper $dataObjectHelper
     * @param UploaderPool $uploaderPool
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ShopRepositoryInterface $shopRepository,
        PageFactory $resultPageFactory,
        ShopInterfaceFactory $shopFactory,
        DataObjectProcessor $dataObjectProcessor,
        DataObjectHelper $dataObjectHelper,
        UploaderPool $uploaderPool,
        DataPersistorInterface $dataPersistor
    ) {
        $this->shopFactory         = $shopFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->dataObjectHelper    = $dataObjectHelper;
        $this->uploaderPool        = $uploaderPool;
        $this->dataPersistor       = $dataPersistor;
        parent::__construct($context, $coreRegistry, $shopRepository, $resultPageFactory);
    }

    /**
     * run the action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        /** @var \Levelshoes\Shopfinder\Api\Data\ShopInterface $shop */
        $shop = null;
        $postData = $this->getRequest()->getPostValue();
        $data = $postData;
        $id = !empty($data['shop_id']) ? $data['shop_id'] : null;
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            if ($id) {
                $shop = $this->shopRepository->getById((int)$id);
            } else {
                unset($data['shop_id']);
                $shop = $this->shopFactory->create();
            }
            $shopimage = $this->getUploader('image')->uploadFileAndGetName('shopimage', $data);
            $data['shopimage'] = $shopimage;
            $this->dataObjectHelper->populateWithArray($shop, $data, ShopInterface::class);
            $this->shopRepository->save($shop);
            $this->messageManager->addSuccessMessage(__('You saved the Shop'));
            $this->dataPersistor->clear('levelshoes_shopfinder_shop');
            if ($this->getRequest()->getParam('back')) {
                $resultRedirect->setPath('levelshoes_shopfinder/shop/edit', ['shop_id' => $shop->getId()]);
            } else {
                $resultRedirect->setPath('levelshoes_shopfinder/shop');
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->dataPersistor->set('levelshoes_shopfinder_shop', $postData);
            $resultRedirect->setPath('levelshoes_shopfinder/shop/edit', ['shop_id' => $id]);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was a problem saving the Shop'));
            $this->dataPersistor->set('levelshoes_shopfinder_shop', $postData);
            $resultRedirect->setPath('levelshoes_shopfinder/shop/edit', ['shop_id' => $id]);
        }
        return $resultRedirect;
    }

    /**
     * @param string $type
     * @return \Levelshoes\Shopfinder\Model\Uploader
     * @throws \Exception
     */
    protected function getUploader($type)
    {
        return $this->uploaderPool->getUploader($type);
    }
}
