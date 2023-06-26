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
interface ShopInterface
{
    /**
     * ID
     * 
     * @var string
     */
    const SHOP_ID = 'shop_id';

    /**
     * Shop Name attribute constant
     * 
     * @var string
     */
    const SHOPNAME = 'shopname';

    /**
     * Identifier attribute constant
     * 
     * @var string
     */
    const IDENTIFIER = 'identifier';

    /**
     * Address attribute constant
     * 
     * @var string
     */
    const ADDRESSLINEONE = 'addresslineone';

    /**
     * Address attribute constant
     * 
     * @var string
     */
    const ADDRESSLINETWO = 'addresslinetwo';

    /**
     * City attribute constant
     * 
     * @var string
     */
    const CITY = 'city';

    /**
     * Country attribute constant
     * 
     * @var string
     */
    const COUNTRY = 'country';

    /**
     * State / Province attribute constant
     * 
     * @var string
     */
    const STATE = 'state';

    /**
     * Postal / Zipcode attribute constant
     * 
     * @var string
     */
    const ZIPCODE = 'zipcode';

    /**
     * Phone attribute constant
     * 
     * @var string
     */
    const PHONE = 'phone';

    /**
     * Latitude attribute constant
     * 
     * @var string
     */
    const LATITUDE = 'latitude';

    /**
     * Longitude attribute constant
     * 
     * @var string
     */
    const LONGITUDE = 'longitude';

    /**
     * Email attribute constant
     * 
     * @var string
     */
    const EMAIL = 'email';

    /**
     * Shop Image attribute constant
     * 
     * @var string
     */
    const SHOPIMAGE = 'shopimage';

    /**
     * Status attribute constant
     * 
     * @var string
     */
    const STATUS = 'status';

    /**
     * Can Collect attribute constant
     * 
     * @var string
     */
    const CANCOLLECT = 'cancollect';

    /**
     * Shop Description attribute constant
     * 
     * @var string
     */
    const SHOPDESCRIPTION = 'shopdescription';

    /**
     * Shop Open Time Information attribute constant
     * 
     * @var string
     */
    const SHOPOPENTIMEDETAIL = 'shopopentimedetail';

    /**
     * Store View attribute constant
     * 
     * @var string
     */
    const STOREVIEW = 'storeview';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getShopId();

    /**
     * Set ID
     *
     * @param int $shopId
     * @return ShopInterface
     */
    public function setShopId($shopId);

    /**
     * Get Shop Name
     *
     * @return mixed
     */
    public function getShopname();

    /**
     * Set Shop Name
     *
     * @param mixed $shopname
     * @return ShopInterface
     */
    public function setShopname($shopname);

    /**
     * Get Identifier
     *
     * @return mixed
     */
    public function getIdentifier();

    /**
     * Set Identifier
     *
     * @param mixed $identifier
     * @return ShopInterface
     */
    public function setIdentifier($identifier);

    /**
     * Get Address
     *
     * @return mixed
     */
    public function getAddresslineone();

    /**
     * Set Address
     *
     * @param mixed $addresslineone
     * @return ShopInterface
     */
    public function setAddresslineone($addresslineone);

    /**
     * Get Address
     *
     * @return mixed
     */
    public function getAddresslinetwo();

    /**
     * Set Address
     *
     * @param mixed $addresslinetwo
     * @return ShopInterface
     */
    public function setAddresslinetwo($addresslinetwo);

    /**
     * Get City
     *
     * @return mixed
     */
    public function getCity();

    /**
     * Set City
     *
     * @param mixed $city
     * @return ShopInterface
     */
    public function setCity($city);

    /**
     * Get Country
     *
     * @return mixed
     */
    public function getCountry();

    /**
     * Set Country
     *
     * @param mixed $country
     * @return ShopInterface
     */
    public function setCountry($country);

    /**
     * Get State / Province
     *
     * @return mixed
     */
    public function getState();

    /**
     * Set State / Province
     *
     * @param mixed $state
     * @return ShopInterface
     */
    public function setState($state);

    /**
     * Get Postal / Zipcode
     *
     * @return mixed
     */
    public function getZipcode();

    /**
     * Set Postal / Zipcode
     *
     * @param mixed $zipcode
     * @return ShopInterface
     */
    public function setZipcode($zipcode);

    /**
     * Get Phone
     *
     * @return mixed
     */
    public function getPhone();

    /**
     * Set Phone
     *
     * @param mixed $phone
     * @return ShopInterface
     */
    public function setPhone($phone);

    /**
     * Get Latitude
     *
     * @return mixed
     */
    public function getLatitude();

    /**
     * Set Latitude
     *
     * @param mixed $latitude
     * @return ShopInterface
     */
    public function setLatitude($latitude);

    /**
     * Get Longitude
     *
     * @return mixed
     */
    public function getLongitude();

    /**
     * Set Longitude
     *
     * @param mixed $longitude
     * @return ShopInterface
     */
    public function setLongitude($longitude);

    /**
     * Get Email
     *
     * @return mixed
     */
    public function getEmail();

    /**
     * Set Email
     *
     * @param mixed $email
     * @return ShopInterface
     */
    public function setEmail($email);

    /**
     * Get Shop Image
     *
     * @return mixed
     */
    public function getShopimage();

    /**
     * Set Shop Image
     *
     * @param mixed $shopimage
     * @return ShopInterface
     */
    public function setShopimage($shopimage);

    /**
     * Get Status
     *
     * @return mixed
     */
    public function getStatus();

    /**
     * Set Status
     *
     * @param mixed $status
     * @return ShopInterface
     */
    public function setStatus($status);

    /**
     * Get Can Collect
     *
     * @return mixed
     */
    public function getCancollect();

    /**
     * Set Can Collect
     *
     * @param mixed $cancollect
     * @return ShopInterface
     */
    public function setCancollect($cancollect);

    /**
     * Get Shop Description
     *
     * @return mixed
     */
    public function getShopdescription();

    /**
     * Set Shop Description
     *
     * @param mixed $shopdescription
     * @return ShopInterface
     */
    public function setShopdescription($shopdescription);

    /**
     * Get Shop Open Time Information
     *
     * @return mixed
     */
    public function getShopopentimedetail();

    /**
     * Set Shop Open Time Information
     *
     * @param mixed $shopopentimedetail
     * @return ShopInterface
     */
    public function setShopopentimedetail($shopopentimedetail);

    /**
     * Get Store View
     *
     * @return mixed
     */
    public function getStoreview();

    /**
     * Set Store View
     *
     * @param mixed $storeview
     * @return ShopInterface
     */
    public function setStoreview($storeview);

    /**
     * Get Shop Image URL
     *
     * @return string
     */
    public function getShopimageUrl();
}
