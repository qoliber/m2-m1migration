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

namespace Qoliber\MigrationTool\Model\Import;

use Magento\Framework\Exception\LocalizedException;
use Zend_Db_Adapter_Exception;
use Zend_Db_Exception;
use Zend_Db_Statement_Exception;

class GallerySync extends EavValuesSync
{
    protected bool $truncate = true;
    protected bool $matchMissingColumns = false;
    protected bool $nullifyValueId = false;

    /**
     * @return string[]
     */
    protected function getTablesToSync(): array
    {
        return ['catalog_product_entity_media_gallery' => 'catalog_product_entity_media_gallery'];
    }

    public function getEntityTypeId(): ?int
    {
        return 4;
    }

    /**
     * @param $m1Entity
     * @param $matchingColumns
     * @return array
     */
    public function prepareRowToInsert($m1Entity, $matchingColumns): array
    {
        $m1Entity = parent::prepareRowToInsert($m1Entity, $matchingColumns);

        if (!empty($m1Entity)) {
            $m1Entity['media_type'] = 'image';
            unset($m1Entity['entity_id']);
        }

        return $m1Entity;
    }

    /**
     * @param bool $delta
     * @throws LocalizedException|Zend_Db_Exception|Zend_Db_Statement_Exception|Zend_Db_Adapter_Exception
     */
    public function sync(bool $delta = false): void
    {
        $this->initAttributeIds();
        $this->initEntityIds();

        foreach ($this->getTablesToSync() as $m1Table => $m2Table) {
            $this->syncData($m1Table, $m2Table, $delta ? $this->getDeltaCondition(4) : null, ['value']);
            $this->cleanBroken($m2Table);
        }
    }

    /**
     * @param $m1Table
     * @param $m2Table
     * @return array
     * @throws LocalizedException
     * @throws Zend_Db_Exception
     * @throws Zend_Db_Statement_Exception
     */
    public function matchColumns($m1Table, $m2Table): array
    {
        $matchingColumns = parent::matchColumns($m1Table, $m2Table);
        $matchingColumns[] = 'media_type';

        return $matchingColumns;
    }
}
