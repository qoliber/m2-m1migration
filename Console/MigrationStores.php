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
use Qoliber\MigrationTool\Model\Import\Setup\StoreGroups;

use Qoliber\MigrationTool\Model\Import\Setup\StoreGroups as StoreGroupsImport;
use Qoliber\MigrationTool\Model\Import\Setup\Stores as StoresImport;
use Qoliber\MigrationTool\Model\Import\Setup\Websites as WebsitesImport;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zend_Db_Exception;
use Zend_Db_Statement_Exception;

class MigrationStores extends MigrationAbstract
{
    /** @var string  */
    public const NAME = "qoliber:import:stores";

    /** @var string  */
    public const DESCRIPTION = "Import stores from Magento 1 database";

    protected StoresImport $storesImport;
    protected StoreGroupsImport $storeGroupsImport;
    protected WebsitesImport $websitesImport;

    /**
     * MigrationTool constructor.
     * @param State $state
     * @param StoresImport $stores
     * @param StoreGroupsImport $storeGroups
     * @param WebsitesImport $websites
     */
    public function __construct(
        State $state,
        StoresImport $stores,
        StoreGroupsImport $storeGroups,
        WebsitesImport $websites
    ) {
        $this->storesImport = $stores;
        $this->storeGroupsImport = $storeGroups;
        $this->websitesImport = $websites;
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

        $this->output->writeln('Importing websites config...');
        $this->websitesImport->insertConfig();

        $this->output->writeln('Importing store groups config...');
        $this->storeGroupsImport->insertConfig();

        $this->output->writeln('Importing store views config...');
        $this->storesImport->insertConfig();

        return Cli::RETURN_SUCCESS;
    }
}
