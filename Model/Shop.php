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
namespace Levelshoes\Shopfinder\Model;

use Levelshoes\Shopfinder\Api\Data\ShopInterface;
use Levelshoes\Shopfinder\Model\UploaderPool;
use Magento\Framework\Data\Collection\AbstractDb as DbCollection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Shop extends AbstractModel implements ShopInterface
{
    /**
     * Cache tag
     * 
     * @var string
     */
    const CACHE_TAG = 'levelshoes_shopfinder_shop';

    /**
     * Cache tag
     * 
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Event prefix
     * 
     * @var string
     */
    protected $_eventPrefix = 'levelshoes_shopfinder_shop';

    /**
     * Event object
     * 
     * @var string
     */
    protected $_eventObject = 'shop';

    /**
     * Uploader pool
     * 
     * @var UploaderPool
     */
    protected $uploaderPool;

    /**
     * constructor
     * 
     * @param Context $context
     * @param Registry $registry
     * @param UploaderPool $uploaderPool
     * @param AbstractResource $resource
     * @param DbCollection $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        UploaderPool $uploaderPool,
        AbstractResource $resource = null,
        DbCollection $resourceCollection = null,
        array $data = []
    ) {
        $this->uploaderPool = $uploaderPool;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Levelshoes\Shopfinder\Model\ResourceModel\Shop::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get Shop id
     *
     * @return array
     */
    public function getShopId()
    {
        return $this->getData(ShopInterface::SHOP_ID);
    }

    /**
     * set Shop id
     *
     * @param int $shopId
     * @return ShopInterface
     */
    public function setShopId($shopId)
    {
        return $this->setData(ShopInterface::SHOP_ID, $shopId);
    }

    /**
     * set Shop Name
     *
     * @param mixed $shopname
     * @return ShopInterface
     */
    public function setShopname($shopname)
    {
        return $this->setData(ShopInterface::SHOPNAME, $shopname);
    }

    /**
     * get Shop Name
     *
     * @return string
     */
    public function getShopname()
    {
        return $this->getData(ShopInterface::SHOPNAME);
    }

    /**
     * set Identifier
     *
     * @param mixed $identifier
     * @return ShopInterface
     */
    public function setIdentifier($identifier)
    {
        return $this->setData(ShopInterface::IDENTIFIER, $identifier);
    }

    /**
     * get Identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->getData(ShopInterface::IDENTIFIER);
    }

    /**
     * set Address
     *
     * @param mixed $addresslineone
     * @return ShopInterface
     */
    public function setAddresslineone($addresslineone)
    {
        return $this->setData(ShopInterface::ADDRESSLINEONE, $addresslineone);
    }

    /**
     * get Address
     *
     * @return string
     */
    public function getAddresslineone()
    {
        return $this->getData(ShopInterface::ADDRESSLINEONE);
    }

    /**
     * set Address
     *
     * @param mixed $addresslinetwo
     * @return ShopInterface
     */
    public function setAddresslinetwo($addresslinetwo)
    {
        return $this->setData(ShopInterface::ADDRESSLINETWO, $addresslinetwo);
    }

    /**
     * get Address
     *
     * @return string
     */
    public function getAddresslinetwo()
    {
        return $this->getData(ShopInterface::ADDRESSLINETWO);
    }

    /**
     * set City
     *
     * @param mixed $city
     * @return ShopInterface
     */
    public function setCity($city)
    {
        return $this->setData(ShopInterface::CITY, $city);
    }

    /**
     * get City
     *
     * @return string
     */
    public function getCity()
    {
        return $this->getData(ShopInterface::CITY);
    }

    /**
     * set Country
     *
     * @param mixed $country
     * @return ShopInterface
     */
    public function setCountry($country)
    {
        return $this->setData(ShopInterface::COUNTRY, $country);
    }

    /**
     * get Country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->getData(ShopInterface::COUNTRY);
    }

    /**
     * set State / Province
     *
     * @param mixed $state
     * @return ShopInterface
     */
    public function setState($state)
    {
        return $this->setData(ShopInterface::STATE, $state);
    }

    /**
     * get State / Province
     *
     * @return string
     */
    public function getState()
    {
        return $this->getData(ShopInterface::STATE);
    }

    /**
     * set Postal / Zipcode
     *
     * @param mixed $zipcode
     * @return ShopInterface
     */
    public function setZipcode($zipcode)
    {
        return $this->setData(ShopInterface::ZIPCODE, $zipcode);
    }

    /**
     * get Postal / Zipcode
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->getData(ShopInterface::ZIPCODE);
    }

    /**
     * set Phone
     *
     * @param mixed $phone
     * @return ShopInterface
     */
    public function setPhone($phone)
    {
        return $this->setData(ShopInterface::PHONE, $phone);
    }

    /**
     * get Phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->getData(ShopInterface::PHONE);
    }

    /**
     * set Latitude
     *
     * @param mixed $latitude
     * @return ShopInterface
     */
    public function setLatitude($latitude)
    {
        return $this->setData(ShopInterface::LATITUDE, $latitude);
    }

    /**
     * get Latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->getData(ShopInterface::LATITUDE);
    }

    /**
     * set Longitude
     *
     * @param mixed $longitude
     * @return ShopInterface
     */
    public function setLongitude($longitude)
    {
        return $this->setData(ShopInterface::LONGITUDE, $longitude);
    }

    /**
     * get Longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->getData(ShopInterface::LONGITUDE);
    }

    /**
     * set Email
     *
     * @param mixed $email
     * @return ShopInterface
     */
    public function setEmail($email)
    {
        return $this->setData(ShopInterface::EMAIL, $email);
    }

    /**
     * get Email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getData(ShopInterface::EMAIL);
    }

    /**
     * set Shop Image
     *
     * @param mixed $shopimage
     * @return ShopInterface
     */
    public function setShopimage($shopimage)
    {
        return $this->setData(ShopInterface::SHOPIMAGE, $shopimage);
    }

    /**
     * get Shop Image
     *
     * @return string
     */
    public function getShopimage()
    {
        return $this->getData(ShopInterface::SHOPIMAGE);
    }

    /**
     * set Status
     *
     * @param mixed $status
     * @return ShopInterface
     */
    public function setStatus($status)
    {
        return $this->setData(ShopInterface::STATUS, $status);
    }

    /**
     * get Status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(ShopInterface::STATUS);
    }

    /**
     * set Can Collect
     *
     * @param mixed $cancollect
     * @return ShopInterface
     */
    public function setCancollect($cancollect)
    {
        return $this->setData(ShopInterface::CANCOLLECT, $cancollect);
    }

    /**
     * get Can Collect
     *
     * @return string
     */
    public function getCancollect()
    {
        return $this->getData(ShopInterface::CANCOLLECT);
    }

    /**
     * set Shop Description
     *
     * @param mixed $shopdescription
     * @return ShopInterface
     */
    public function setShopdescription($shopdescription)
    {
        return $this->setData(ShopInterface::SHOPDESCRIPTION, $shopdescription);
    }

    /**
     * get Shop Description
     *
     * @return string
     */
    public function getShopdescription()
    {
        return $this->getData(ShopInterface::SHOPDESCRIPTION);
    }

    /**
     * set Shop Open Time Information
     *
     * @param mixed $shopopentimedetail
     * @return ShopInterface
     */
    public function setShopopentimedetail($shopopentimedetail)
    {
        return $this->setData(ShopInterface::SHOPOPENTIMEDETAIL, $shopopentimedetail);
    }

    /**
     * get Shop Open Time Information
     *
     * @return string
     */
    public function getShopopentimedetail()
    {
        return $this->getData(ShopInterface::SHOPOPENTIMEDETAIL);
    }

    /**
     * set Store View
     *
     * @param mixed $storeview
     * @return ShopInterface
     */
    public function setStoreview($storeview)
    {
        return $this->setData(ShopInterface::STOREVIEW, $storeview);
    }

    /**
     * get Store View
     *
     * @return string
     */
    public function getStoreview()
    {
        return $this->getData(ShopInterface::STOREVIEW);
    }

    /**
     * @return bool|string
     * @throws LocalizedException
     */
    public function getShopimageUrl()
    {
        $url = false;
        $shopimage = $this->getShopimage();
        if ($shopimage) {
            if (is_string($shopimage)) {
                $uploader = $this->uploaderPool->getUploader('image');
                $url = $uploader->getBaseUrl().$uploader->getBasePath().$shopimage;
            } else {
                throw new LocalizedException(
                    __('Something went wrong while getting the Shop&#x20;Image url.')
                );
            }
        }
        return $url;
    }
}
