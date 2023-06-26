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
namespace Levelshoes\Shopfinder\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * install tables
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('levelshoes_shopfinder_shop')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('levelshoes_shopfinder_shop')
            )
            ->addColumn(
                'shop_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'Shop ID'
            )
            ->addColumn(
                'shopname',
                Table::TYPE_TEXT,
                255,
                ['nullable => false'],
                'Shop Shop Name'
            )
            ->addColumn(
                'identifier',
                Table::TYPE_TEXT,
                255,
                [],
                'Shop Identifier'
            )
            ->addColumn(
                'addresslineone',
                Table::TYPE_TEXT,
                255,
                ['nullable => false'],
                'Shop Address'
            )
            ->addColumn(
                'addresslinetwo',
                Table::TYPE_TEXT,
                255,
                [],
                'Shop Address'
            )
            ->addColumn(
                'city',
                Table::TYPE_TEXT,
                255,
                [],
                'Shop City'
            )
            ->addColumn(
                'country',
                Table::TYPE_TEXT,
                3,
                ['nullable => false'],
                'Shop Country'
            )
            ->addColumn(
                'state',
                Table::TYPE_TEXT,
                255,
                [],
                'Shop State / Province'
            )
            ->addColumn(
                'zipcode',
                Table::TYPE_TEXT,
                255,
                ['nullable => false'],
                'Shop Postal / Zipcode'
            )
            ->addColumn(
                'phone',
                Table::TYPE_TEXT,
                255,
                [],
                'Shop Phone'
            )
            ->addColumn(
                'latitude',
                Table::TYPE_TEXT,
                255,
                [],
                'Shop Latitude'
            )
            ->addColumn(
                'longitude',
                Table::TYPE_TEXT,
                255,
                [],
                'Shop Longitude'
            )
            ->addColumn(
                'email',
                Table::TYPE_TEXT,
                255,
                [],
                'Shop Email'
            )
            ->addColumn(
                'shopimage',
                Table::TYPE_TEXT,
                255,
                [],
                'Shop Shop Image'
            )
            ->addColumn(
                'status',
                Table::TYPE_INTEGER,
                1,
                ['nullable => false'],
                'Shop Status'
            )
            ->addColumn(
                'cancollect',
                Table::TYPE_INTEGER,
                null,
                ['nullable => false'],
                'Shop Can Collect'
            )
            ->addColumn(
                'shopdescription',
                Table::TYPE_TEXT,
                '64k',
                ['nullable => false'],
                'Shop Shop Description'
            )
            ->addColumn(
                'shopopentimedetail',
                Table::TYPE_TEXT,
                '64k',
                [],
                'Shop Shop Open Time Information'
            )
            ->addColumn(
                'storeview',
                Table::TYPE_INTEGER,
                null,
                ['nullable => false'],
                'Shop Store View'
            )

            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'nullable' => false,
                    'default' => Table::TIMESTAMP_INIT
                ],
                'Shop Created At'
            )
            ->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'nullable' => false,
                    'default' => Table::TIMESTAMP_INIT_UPDATE
                ],
                'Shop Updated At'
            )
            ->setComment('Shop Table');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('levelshoes_shopfinder_shop'),
                $setup->getIdxName(
                    $installer->getTable('levelshoes_shopfinder_shop'),
                    ['shopname', 'identifier', 'addresslineone', 'addresslinetwo', 'city', 'state', 'zipcode', 'phone', 'latitude', 'longitude', 'email', 'shopimage', 'shopdescription', 'shopopentimedetail'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['shopname', 'identifier', 'addresslineone', 'addresslinetwo', 'city', 'state', 'zipcode', 'phone', 'latitude', 'longitude', 'email', 'shopimage', 'shopdescription', 'shopopentimedetail'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        $installer->endSetup();
    }
}
