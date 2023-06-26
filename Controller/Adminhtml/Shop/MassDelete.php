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
use Levelshoes\Shopfinder\Controller\Adminhtml\Shop\MassAction;

class MassDelete extends MassAction
{
    /**
     * @param \Levelshoes\Shopfinder\Api\Data\ShopInterface $shop
     * @return $this
     */
    protected function massAction(ShopInterface $shop)
    {
        $this->shopRepository->delete($shop);
        return $this;
    }
}
