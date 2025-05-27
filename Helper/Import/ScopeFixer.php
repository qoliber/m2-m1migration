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

use Exception;
use Magento\Framework\Exception\LocalizedException;
use Qoliber\MigrationTool\Helper\Connection;
use Zend_Db_Statement_Exception;

class ScopeFixer extends Connection
{
    /**
     * @throws LocalizedException
     * @throws Zend_Db_Statement_Exception
     * @throws Exception
     */
    public function fixScopes() : void
    {
        if ($this->initializeMagento1Connection()) {
            $m1Attributes = $this->getM1connection()->fetchPairs($this->getM1connection()
                ->select()
                ->from($this->getM1TableName('eav_attribute'), ['attribute_code', 'attribute_id'])
                ->where("entity_type_id IN(3,4)"));

            $m2Attributes = $this->getM2Connection()->fetchPairs($this->getM2Connection()
                ->select()
                ->from($this->getM2Connection()->getTableName('eav_attribute'), ['attribute_code', 'attribute_id'])
                ->where("entity_type_id IN(3,4)"));

            $m1Scopes = $this->getM1connection()->fetchPairs(
                $this->getM1connection()
                ->select()
                ->from($this->getM1TableName('catalog_eav_attribute'), ['attribute_id', 'is_global'])
            );

            $attributesMap = [];

            foreach ($m1Attributes as $attributeCode => $attributeId) {
                $attributesMap[$attributeId] = $m2Attributes[$attributeCode] ?? null;
            }

            $scopesUpdate = [];

            foreach (array_filter($attributesMap) as $m1Attribute => $m2Attribute) {
                $scopesUpdate[$m2Attribute] = $m1Scopes[$m1Attribute] ?? null;
            }

            foreach ($scopesUpdate as $attributeId => $isGlobal) {
                if (!is_null($isGlobal)) {
                    $this->getM2Connection()->update(
                        $this->getM2Connection()->getTableName('catalog_eav_attribute'),
                        ['is_global' => $isGlobal],
                        "attribute_id = $attributeId"
                    );
                }
            }
        } else {
            throw new Exception("Couldn't connect to M1 database.");
        }
    }
}
