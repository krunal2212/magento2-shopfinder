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
namespace Levelshoes\Shopfinder\Controller\Adminhtml;

use Levelshoes\Shopfinder\Api\ShopRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

abstract class Shop extends Action
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
     * constructor
     * 
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ShopRepositoryInterface $shopRepository
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ShopRepositoryInterface $shopRepository,
        PageFactory $resultPageFactory
    ) {
        $this->coreRegistry      = $coreRegistry;
        $this->shopRepository    = $shopRepository;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
}
