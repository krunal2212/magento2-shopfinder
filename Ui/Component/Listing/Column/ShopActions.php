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
namespace Levelshoes\Shopfinder\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class ShopActions extends Column
{
    /**
     * Url path  to edit
     * 
     * @var string
     */
    const URL_PATH_EDIT = 'levelshoes_shopfinder/shop/edit';

    /**
     * Url path  to delete
     * 
     * @var string
     */
    const URL_PATH_DELETE = 'levelshoes_shopfinder/shop/delete';

    /**
     * Url builder
     * 
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * constructor
     * 
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['shop_id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT,
                                [
                                    'shop_id' => $item['shop_id']
                                ]
                            ),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'shop_id' => $item['shop_id']
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete "${ $.$data.shopname }"'),
                                'message' => __('Are you sure you wan\'t to delete the Shop "${ $.$data.shopname }" ?')
                            ]
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}
