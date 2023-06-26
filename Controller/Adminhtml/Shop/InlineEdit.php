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
use Levelshoes\Shopfinder\Api\ShopRepositoryInterface;
use Levelshoes\Shopfinder\Controller\Adminhtml\Shop as ShopController;
use Levelshoes\Shopfinder\Model\ResourceModel\Shop as ShopResourceModel;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class InlineEdit extends ShopController
{
    /**
     * Core registry
     * 
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Shop repository
     * 
     * @var ShopRepositoryInterface
     */
    protected $shopRepository;

    /**
     * Page factory
     * 
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Data object processor
     * 
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * Data object helper
     * 
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * JSON Factory
     * 
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * Shop resource model
     * 
     * @var ShopResourceModel
     */
    protected $shopResourceModel;

    /**
     * constructor
     * 
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ShopRepositoryInterface $shopRepository
     * @param PageFactory $resultPageFactory
     * @param DataObjectProcessor $dataObjectProcessor
     * @param DataObjectHelper $dataObjectHelper
     * @param JsonFactory $jsonFactory
     * @param ShopResourceModel $shopResourceModel
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ShopRepositoryInterface $shopRepository,
        PageFactory $resultPageFactory,
        DataObjectProcessor $dataObjectProcessor,
        DataObjectHelper $dataObjectHelper,
        JsonFactory $jsonFactory,
        ShopResourceModel $shopResourceModel
    ) {
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->dataObjectHelper    = $dataObjectHelper;
        $this->jsonFactory         = $jsonFactory;
        $this->shopResourceModel   = $shopResourceModel;
        parent::__construct($context, $coreRegistry, $shopRepository, $resultPageFactory);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $shopId) {
            /** @var \Levelshoes\Shopfinder\Model\Shop|\Levelshoes\Shopfinder\Api\Data\ShopInterface $shop */
            $shop = $this->shopRepository->getById((int)$shopId);
            try {
                $shopData = $postItems[$shopId];
                $this->dataObjectHelper->populateWithArray($shop, $shopData, ShopInterface::class);
                $this->shopResourceModel->saveAttribute($shop, array_keys($shopData));
            } catch (LocalizedException $e) {
                $messages[] = $this->getErrorWithShopId($shop, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithShopId($shop, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithShopId(
                    $shop,
                    __('Something went wrong while saving the Shop.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add Shop id to error message
     *
     * @param \Levelshoes\Shopfinder\Api\Data\ShopInterface $shop
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithShopId(ShopInterface $shop, $errorText)
    {
        return '[Shop ID: ' . $shop->getId() . '] ' . $errorText;
    }
}
