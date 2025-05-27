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

use Magento\Bundle\Model\Product\Type;
use Qoliber\MigrationTool\Model\Import\SyncAbstract;
use Qoliber\Collection\Model\Product\Type\Collection;

/**
 * Class ProductSync
 * @package Qoliber\MigrationTool\Model\Import\Entities
 */
class ProductSync extends SyncAbstract
{
    /**
     * @var bool
     */
    protected bool $truncate = true;

    /**
     * @var bool
     */
    protected bool $matchMissingColumns = false;

    /**
     * @var bool
     */
    protected bool $syncEavValues = true;

    /**
     * @param $m1Entity
     * @param $matchingColumns
     * @return array
     */
    public function prepareRowToInsert($m1Entity, $matchingColumns): array
    {
        $m1Entity['attribute_set_id'] = 4;
        $m1Entity['type_id'] = $m1Entity['entity_type_id'];
        unset($m1Entity['entity_type_id']);

        return $m1Entity;
    }

    /**
     * @return array
     */
    protected function getTablesToSync(): array
    {
        return [
            'catalog_product_entity' => $this->connectionHelper->getM2Connection()->getTableName('catalog_product_entity')
        ];
    }

    protected function getEntityTypeId(): ?int
    {
        return 4;
    }
}
