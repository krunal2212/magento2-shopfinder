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
namespace Levelshoes\Shopfinder\Api\Data;

/**
 * @api
 */
interface ShopSearchResultInterface
{
    /**
     * Get Finders list.
     *
     * @return \Levelshoes\Shopfinder\Api\Data\ShopInterface[]
     */
    public function getItems();

    /**
     * Set Finders list.
     *
     * @param \Levelshoes\Shopfinder\Api\Data\ShopInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
