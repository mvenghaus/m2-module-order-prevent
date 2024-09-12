<?php

namespace Mvenghaus\OrderPrevent\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $tableName = 'order_prevent_rules';
        $table = $setup->getConnection()
            ->newTable($setup->getTable($tableName))
            ->addColumn('id', Table::TYPE_INTEGER, null, ['primary' => true, 'identity' => true, 'nullable' => false])
            ->addColumn('company', Table::TYPE_TEXT, 255, ['nullable' => false], 'Company')
            ->addColumn('firstname', Table::TYPE_TEXT, 255, ['nullable' => false], 'Firstname')
            ->addColumn('lastname', Table::TYPE_TEXT, 255, ['nullable' => false], 'Lastname')
            ->addColumn('postcode', Table::TYPE_TEXT, 255, ['nullable' => false], 'Postcode')
            ->addColumn('city', Table::TYPE_TEXT, 255, ['nullable' => false], 'City')
            ->addColumn('email', Table::TYPE_TEXT, 255, ['nullable' => false], 'Email')
            ->addColumn('error_message', Table::TYPE_TEXT, null, [], 'Error Message');

        $setup->getConnection()->dropTable($tableName);
        $setup->getConnection()->createTable($table);
    }
}
