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
use Qoliber\MigrationTool\Model\Import\Setup\Tax;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zend_Db_Adapter_Exception;
use Zend_Db_Exception;
use Zend_Db_Statement_Exception;

class MigrationTax extends MigrationAbstract
{
    /** @var string  */
    public const NAME = "qoliber:import:tax";

    /** @var string  */
    public const DESCRIPTION = "Import taxes from Magento 1 database";

    protected Tax $tax;

    /**
     * MigrationToolTax constructor.
     *
     * @param Tax $tax
     * @param State $state
     */
    public function __construct(Tax $tax, State $state)
    {
        parent::__construct($state);
        $this->tax = $tax;
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(self::NAME)->setDescription(self::DESCRIPTION);
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws LocalizedException
     * @throws Zend_Db_Adapter_Exception
     * @throws Zend_Db_Exception
     * @throws Zend_Db_Statement_Exception
     */
    public function migrate(InputInterface $input, OutputInterface $output) : int
    {
        $this->init($input, $output);

        $this->output->writeln('<info>Importing tax settings...</info>');
        $this->tax->importData();

        return Cli::RETURN_SUCCESS;
    }
}
