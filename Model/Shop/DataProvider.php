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
namespace Levelshoes\Shopfinder\Model\Shop;

use Levelshoes\Shopfinder\Model\ResourceModel\Shop\CollectionFactory as ShopCollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * Loaded data cache
     * 
     * @var array
     */
    protected $loadedData;

    /**
     * Data persistor
     * 
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * constructor
     * 
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ShopCollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ShopCollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Levelshoes\Shopfinder\Model\Shop $shop */
        foreach ($items as $shop) {
            $this->loadedData[$shop->getId()] = $shop->getData();

            if (isset($this->loadedData[$shop->getId()]['shopimage'])) {
                $shopimage = [];
                $shopimage[0]['name'] = $shop->getShopimage();
                $shopimage[0]['url'] = $shop->getShopimageUrl();
                $this->loadedData[$shop->getId()]['shopimage'] = $shopimage;
            }
        }
        $data = $this->dataPersistor->get('levelshoes_shopfinder_shop');
        if (!empty($data)) {
            $shop = $this->collection->getNewEmptyItem();
            $shop->setData($data);
            $this->loadedData[$shop->getId()] = $shop->getData();
            $this->dataPersistor->clear('levelshoes_shopfinder_shop');
        }
        return $this->loadedData;
    }
}
