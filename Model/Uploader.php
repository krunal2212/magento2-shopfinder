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

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class Uploader
{
    /**
     * Shop tmp image path
     * 
     * @var string
     */
    const SHOP_IMAGE_TMP_PATH = 'levelshoes_shopfinder/tmp/shop/image';

    /**
     * Shop image path
     * 
     * @var string
     */
    const SHOP_IMAGE_PATH = 'levelshoes_shopfinder/shop/image';

    /**
     * DB file storage
     * 
     * @var Database
     */
    protected $coreFileStorageDatabase;

    /**
     * Uploader factory
     * 
     * @var UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * Store Manager
     * 
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Logger
     * 
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Media directory
     * 
     * @var WriteInterface
     */
    protected $mediaDirectory;

    /**
     * Base tmp path
     * 
     * @var string
     */
    protected $baseTmpPath;

    /**
     * Base path
     * 
     * @var string
     */
    protected $basePath;

    /**
     * Allowd file extensions
     * 
     * @var array
     */
    protected $allowedExtensions = [];

    /**
     * constructor
     * 
     * @param Database $coreFileStorageDatabase
     * @param Filesystem $filesystem
     * @param UploaderFactory $uploaderFactory
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     * @param string $baseTmpPath
     * @param string $basePath
     * @param array $allowedExtensions
     */
    public function __construct(
        Database $coreFileStorageDatabase,
        Filesystem $filesystem,
        UploaderFactory $uploaderFactory,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger,
        $baseTmpPath,
        $basePath,
        array $allowedExtensions = []
    ) {
        $this->coreFileStorageDatabase = $coreFileStorageDatabase;
        $this->uploaderFactory         = $uploaderFactory;
        $this->storeManager            = $storeManager;
        $this->logger                  = $logger;
        $this->baseTmpPath             = $baseTmpPath;
        $this->basePath                = $basePath;
        $this->allowedExtensions       = $allowedExtensions;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
    }

    /**
     * Set base tmp path
     *
     * @param string $baseTmpPath
     *
     * @return void
     */
    public function setBaseTmpPath($baseTmpPath)
    {
        $this->baseTmpPath = $baseTmpPath;
    }

    /**
     * Set base path
     *
     * @param string $basePath
     *
     * @return void
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * Set allowed extensions
     *
     * @param string[] $allowedExtensions
     *
     * @return void
     */
    public function setAllowedExtensions($allowedExtensions)
    {
        $this->allowedExtensions = $allowedExtensions;
    }

    /**
     * Retrieve base tmp path
     *
     * @return string
     */
    public function getBaseTmpPath()
    {
        return $this->baseTmpPath;
    }

    /**
     * Retrieve base path
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Retrieve base path
     *
     * @return string[]
     */
    public function getAllowedExtensions()
    {
        return $this->allowedExtensions;
    }

    /**
     * Retrieve path
     *
     * @param string $path
     * @param string $name
     * @return string
     */
    public function getFilePath($path, $name)
    {
        return rtrim($path, '/') . '/' . ltrim($name, '/');
    }

    /**
     * Checking file for moving and move it
     *
     * @param string $name
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function moveFileFromTmp($name)
    {
        $baseTmpPath = $this->getBaseTmpPath();
        $basePath = $this->getBasePath();

        $baseFilePath = $this->getFilePath($basePath, $name);
        $baseTmpFilePath = $this->getFilePath($baseTmpPath, $name);

        try {
            $this->coreFileStorageDatabase->copyFile(
                $baseTmpFilePath,
                $baseFilePath
            );
            $this->mediaDirectory->renameFile(
                $baseTmpFilePath,
                $baseFilePath
            );
        } catch (\Exception $e) {
            throw new LocalizedException(
                __('Something went wrong while saving the file(s).')
            );
        }

        return $name;
    }

    /**
     * get base url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->storeManager
            ->getStore()
            ->getBaseUrl(
                UrlInterface::URL_TYPE_MEDIA
            );
    }

    /**
     * Checking file for save and save it to tmp dir
     *
     * @param string $fileId
     *
     * @return string[]
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function saveFileToTmpDir($fileId)
    {
        $baseTmpPath = $this->getBaseTmpPath();

        $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
        $uploader->setAllowedExtensions($this->getAllowedExtensions());
        $uploader->setAllowRenameFiles(true);
        $uploader->setFilesDispersion(true);

        $result = $uploader->save($this->mediaDirectory->getAbsolutePath($baseTmpPath));

        if (!$result) {
            throw new LocalizedException(
                __('File can not be saved to the destination folder.')
            );
        }
        /**
         * Workaround for prototype 1.7 methods "isJSON", "evalJSON" on Windows OS
         */
        $result['tmp_name'] = str_replace('\\', '/', $result['tmp_name']);
        $result['path'] = str_replace('\\', '/', $result['path']);
        $result['url'] =  $this->getBaseUrl() . $this->getFilePath($baseTmpPath, $result['file']);

        if (isset($result['file'])) {
            try {
                $relativePath = rtrim($baseTmpPath, '/') . '/' . ltrim($result['file'], '/');
                $this->coreFileStorageDatabase->saveFile($relativePath);
            } catch (\Exception $e) {
                $this->logger->critical($e);
                throw new LocalizedException(
                    __('Something went wrong while saving the file(s).')
                );
            }
        }

        return $result;
    }

    /**
     * @param string $input
     * @param array $data
     * @return string
     */
    public function uploadFileAndGetName($input, $data)
    {
        if (!isset($data[$input])) {
            return '';
        }
        if (is_array($data[$input]) && !empty($data[$input]['delete'])) {
            return '';
        }

        if (isset($data[$input][0]['name']) && isset($data[$input][0]['tmp_name'])) {
            try {
                $result = $this->moveFileFromTmp($data[$input][0]['file']);
                return $result;
            } catch (\Exception $e) {
                return '';
            }
        } elseif (isset($data[$input][0]['name'])) {
            return $data[$input][0]['name'];
        }
        return '';
    }
}
