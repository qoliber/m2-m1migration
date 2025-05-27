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

class Stores extends SetupAbstract
{
    /**
     * @return string
     */
    public function getM1TableName(): string
    {
        return 'core_store';
    }

    /**
     * @return string
     */
    public function getM2TableName(): string
    {
        return 'store';
    }

    /**
     * @return array
     */
    public function getM2TableColumns(): array
    {
        return [
            'store_id',
            'code',
            'website_id',
            'group_id',
            'name',
            'sort_order',
            'is_active'
        ];
    }

    public function getIncrementFields(): string
    {
        return 'store_id';
    }

    public function afterImportData()
    {
    }
}
