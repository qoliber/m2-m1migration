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

class Websites extends SetupAbstract
{
    /**
     * @return string
     */
    public function getM1TableName(): string
    {
        return 'core_website';
    }

    /**
     * @return string
     */
    public function getM2TableName(): string
    {
        return 'store_website';
    }

    /**
     * @return array
     */
    public function getM2TableColumns(): array
    {
        return [
            'website_id',
            'code',
            'name',
            'sort_order',
            'default_group_id',
            'is_default'
        ];
    }

    public function getIncrementFields(): string
    {
        return 'website_id';
    }

    public function afterImportData()
    {

    }

}
