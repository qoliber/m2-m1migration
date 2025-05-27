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

declare(strict_types=1);

namespace Qoliber\MigrationTool\Console;

use Magento\Framework\App\State;
use Magento\Framework\Console\Cli;
use Magento\Framework\Exception\LocalizedException;
use Qoliber\MigrationTool\Model\Import\Entities\CreditMemo as CreditMemoImport;
use Qoliber\MigrationTool\Model\Import\Entities\Invoice as InvoiceImport;
use Qoliber\MigrationTool\Model\Import\Entities\Order as OrderImport;
use Qoliber\MigrationTool\Model\Import\Setup\SequenceTables as SequenceTables;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zend_Db_Exception;
use Zend_Db_Statement_Exception;

class MigrationShipment extends MigrationAbstract
{
    /** @var string  */
    public const NAME = "qoliber:import:shipment";

    /** @var string  */
    public const DESCRIPTION = "Import shipment data";

    protected SequenceTables $sequenceTables;

    /**
     * MigrationToolSales constructor.
     * @param SequenceTables $sequenceTables
     * @param State $state
     */
    public function __construct(
        SequenceTables $sequenceTables,
        State $state
    ) {
        $this->sequenceTables = $sequenceTables;
        parent::__construct($state);
    }

    /**  */
    protected function configure()
    {
        $this->setName(self::NAME)->setDescription(self::DESCRIPTION);
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null
     * @throws LocalizedException
     * @throws Zend_Db_Exception
     * @throws Zend_Db_Statement_Exception
     */
    protected function migrate(InputInterface $input, OutputInterface $output): int
    {
        $this->init($input, $output);
        return Cli::RETURN_SUCCESS;
    }
}
