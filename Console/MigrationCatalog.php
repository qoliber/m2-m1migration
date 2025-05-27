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
use Qoliber\MigrationTool\Model\Import\Catalog as CatalogImport;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zend_Db_Exception;
use Zend_Db_Statement_Exception;

class MigrationCatalog extends MigrationAbstract
{
    /** @var string  */
    public const NAME = "qoliber:import:catalog";

    /** @var string  */
    public const DESCRIPTION = "Import catalog from Magento 1 database";

    /** @var CatalogImport  */
    protected CatalogImport $catalogImport;

    /**
     * @param \Magento\Framework\App\State $state
     * @param \Qoliber\MigrationTool\Model\Import\Catalog $catalogImport
     */
    public function __construct(
        State $state,
        CatalogImport $catalogImport
    ) {
        $this->catalogImport = $catalogImport;
        parent::__construct($state);
    }

    protected function configure()
    {
        $this->setName(self::NAME)->setDescription(self::DESCRIPTION);
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws LocalizedException|Zend_Db_Exception|Zend_Db_Statement_Exception
     */
    protected function migrate(InputInterface $input, OutputInterface $output): int
    {
        $this->init($input, $output);

        $this->output->writeln('Importing only catalog...');
        $this->catalogImport->importCatalog($this->delta);

        return Cli::RETURN_SUCCESS;
    }
}
