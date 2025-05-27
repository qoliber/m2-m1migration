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

namespace Qoliber\MigrationTool\Helper\Import;

use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Qoliber\MigrationTool\Helper\Connection;

class StatusFixer extends Connection
{
    /**
     * @var array
     */
    protected $statuses = [
        Status::STATUS_ENABLED,
        Status::STATUS_DISABLED
    ];

    protected $visibility = [
        Visibility::VISIBILITY_NOT_VISIBLE,
        Visibility::VISIBILITY_IN_CATALOG,
        Visibility::VISIBILITY_IN_SEARCH,
        Visibility::VISIBILITY_BOTH
    ];

    public function fixStatus() : void
    {
        $eavTable = $this->getM2Connection()->getTableName('eav_attribute');
        $statusId = $this->getM2Connection()->fetchOne(
            $this->getM2Connection()->select()->from($eavTable, ['attribute_id'])->where("attribute_code = 'status' AND entity_type_id = 4")
        );
        $visibilityId = $this->getM2Connection()->fetchOne(
            $this->getM2Connection()->select()->from($eavTable, ['attribute_id'])->where("attribute_code = 'visibility' AND entity_type_id = 4")
        );

        $valueTable = $this->getM2Connection()->getTableName('catalog_product_entity_int');

        $cond = join(',', $this->statuses);
        $this->getM2Connection()->update($valueTable, ['value' => Status::STATUS_DISABLED], "attribute_id = $statusId AND value NOT IN($cond)");

        $cond = join(',', $this->visibility);
        $this->getM2Connection()->update($valueTable, ['value' => Visibility::VISIBILITY_NOT_VISIBLE], "attribute_id = $visibilityId AND value NOT IN($cond)");
    }
}
