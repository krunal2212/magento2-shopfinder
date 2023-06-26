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
namespace Levelshoes\Shopfinder\Model\Shop\Source;

use Magento\Framework\Option\ArrayInterface;

class Storeview implements ArrayInterface
{
    protected $_systemStore;
    public function __construct(
        \Magento\Store\Model\System\Store $systemStore
    ) {

        $this->_systemStore = $systemStore;
    }
    /**
     * to option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = $this->_systemStore->getStoreValuesForForm(false, true);
        return $options;
    }
}
