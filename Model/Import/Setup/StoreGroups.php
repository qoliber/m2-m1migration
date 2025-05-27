<?php
/**
 * Copyright © Q-Solutions Studio: eCommerce Qoliber. All rights reserved.
 *
 * @category    Qoliber
 * @package     Qoliber_MigrationTool
 * @author      Jakub Winkler <jwinkler@qoliber.com
 * @author      Sebastian Strojwas <sstrojwas@qoliber.com>
 * @author      Wojciech M. Wnuk <wwnuk@qoliber.com>
 * @author      qoliber <info@qoliber.com>
 */

namespace Qoliber\MigrationTool\Model\Import\Setup;

class StoreGroups extends SetupAbstract
{
    /**
     * @return string
     */
    public function getM1TableName(): string
    {
        return 'core_store_group';
    }

    /**
     * @return string
     */
    public function getM2TableName(): string
    {
        return 'store_group';
    }

    /**
     * @return array
     */
    public function getM2TableColumns(): array
    {
        return [
            'group_id',
            'website_id',
            'name',
            'root_category_id',
            'default_store_id'
        ];
    }

    /**
     * @return string
     */
    public function getIncrementFields(): string
    {
        return 'group_id';
    }

    /**
     * @return void
     */
    public function afterImportData()
    {
        $this->getM2Connection()->query(
            'update `' . $this->getM2TableName() . '`
                    set `code` = lower(replace(name, \' \', \'_\'))'
        );
    }
}
