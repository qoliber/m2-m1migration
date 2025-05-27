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

class Subscribers extends TableImportAbstract
{
    /**
     * @param $m1Entity
     * @param array $matchingColumns
     * @return array
     */
    public function prepareRowToInsert($m1Entity, $matchingColumns = []) : array
    {
        return $m1Entity;
    }

    /**
     * @throws LocalizedException
     * @throws Zend_Db_Adapter_Exception
     * @throws Zend_Db_Exception
     * @throws Zend_Db_Statement_Exception
     */
    public function syncSubscribers() : void
    {
        $this->syncData('newsletter_subscriber', 'newsletter_subscriber');
    }
}
