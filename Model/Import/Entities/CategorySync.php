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

class CategorySync extends SyncAbstract
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
     * @return array
     */
    protected function getTablesToSync(): array
    {
        return [
            'catalog_category_entity' => $this->connectionHelper->getM2Connection()->getTableName('catalog_category_entity')
        ];
    }

    public function prepareRowToInsert($m1Entity, $matchingColumns): array
    {
        unset($m1Entity['entity_type_id']);

        return $m1Entity;
    }

    protected function getEntityTypeId(): ?int
    {
        return 3;
    }
}
