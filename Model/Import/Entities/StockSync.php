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

namespace Qoliber\MigrationTool\Model\Import\Entities;

use Qoliber\MigrationTool\Model\Import\SyncAbstract;

class StockSync extends SyncAbstract
{
    protected bool $truncate = true;
    protected bool $canDelta = false;
    protected string $entityName = 'cataloginventory_stock';

    /**
     * @inheritDoc
     */
    protected function getTablesToSync(): array
    {
        return [
            'cataloginventory_stock_item' => 'cataloginventory_stock_item',
            'cataloginventory_stock_status' => 'cataloginventory_stock_status',
            'cataloginventory_stock_status_idx' => 'cataloginventory_stock_status_idx',
        ];
    }

    /**
     * @return int|null
     */
    protected function getEntityTypeId(): ?int
    {
        return null;
    }

    /**
     * @param $m1Entity
     * @param $matchingColumns
     * @return array
     */
    public function prepareRowToInsert($m1Entity, $matchingColumns): array
    {
        return $m1Entity;
    }

    /**
     * @return string
     */
    protected function getUpdatedAtField(): string
    {
        return '';
    }
}
