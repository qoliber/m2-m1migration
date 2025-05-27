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

use Qoliber\MigrationTool\Helper\Connection;
use Zend_Db_Statement_Mysqli_Exception;

class PriceFixer extends Connection
{
    /**
     * @throws Zend_Db_Statement_Mysqli_Exception
     */
    public function fixPrices() : void
    {
        $catalogProductEntityDatetimeTable = $this->getM2Connection()->getTableName('catalog_product_entity_datetime');
        $catalogProductEntity = $this->getM2Connection()->getTableName('catalog_product_entity');
        $catalogProductEntityDecimal = $this->getM2Connection()->getTableName('catalog_product_entity_decimal');
        $eavAttribute = $this->getM2Connection()->getTableName('eav_attribute');

        $sql = "DELETE FROM $catalogProductEntityDecimal WHERE value IS NULL AND " .
            "attribute_id IN ( SELECT attribute_id FROM $eavAttribute WHERE attribute_code = 'special_price' )";

        try {
            $this->getM2Connection()->query($sql);
        } catch (\Exception $exception) {
            throw new Zend_Db_Statement_Mysqli_Exception($exception->getMessage());
        }

        $sql = "SELECT entity_id FROM $catalogProductEntity WHERE entity_id NOT IN (" .
            "SELECT entity_id FROM $catalogProductEntityDecimal WHERE attribute_id IN (" .
            "SELECT attribute_id FROM $eavAttribute WHERE attribute_code = 'special_price' ))";

        try {
            $entityIds = $this->getM2Connection()->fetchCol($sql);
        } catch (\Exception $exception) {
            throw new Zend_Db_Statement_Mysqli_Exception($exception->getMessage());
        }

        $cond = implode(',', $entityIds);
        $sql = "DELETE FROM $catalogProductEntityDatetimeTable WHERE entity_id IN ($cond) AND " .
            "attribute_id IN ( SELECT attribute_id FROM $eavAttribute WHERE attribute_code IN ('special_from_date', 'special_to_date') )";

        try {
            $this->getM2Connection()->query($sql);
        } catch (\Exception $exception) {
            throw new Zend_Db_Statement_Mysqli_Exception($exception->getMessage());
        }

        $sql = "DELETE FROM `$catalogProductEntityDatetimeTable` WHERE `entity_id` IN(
SELECT `entity_id` FROM `$catalogProductEntity` WHERE `type_id` = 'configurable'
) AND `attribute_id` IN (SELECT attribute_id FROM `$eavAttribute` WHERE `attribute_code` IN ('special_from_date', 'special_to_date'))";

        try {
            $this->getM2Connection()->query($sql);
        } catch (\Exception $exception) {
            throw new Zend_Db_Statement_Mysqli_Exception($exception->getMessage());
        }

        $sql = "DELETE FROM `$catalogProductEntityDecimal` WHERE `entity_id` IN(
SELECT `entity_id` FROM `$catalogProductEntity` WHERE `type_id` = 'configurable'
) AND `attribute_id` IN (SELECT `attribute_id` FROM `$eavAttribute` WHERE `attribute_code` = 'special_price')";

        try {
            $this->getM2Connection()->query($sql);
        } catch (\Exception $exception) {
            throw new Zend_Db_Statement_Mysqli_Exception($exception->getMessage());
        }
    }
}
