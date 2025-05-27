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
use Qoliber\MigrationTool\Model\Import\Setup\Config as ConfigImport;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationConfig extends MigrationAbstract
{
    /** @var string  */
    public const NAME = "qoliber:import:config";

    /** @var string  */
    public const DESCRIPTION = "Config import";

    protected ConfigImport $configImport;

    /**
     * PriceFix constructor.
     * @param ConfigImport $configImport
     * @param State $state
     */
    public function __construct(
        ConfigImport $configImport,
        State $state
    ) {
        parent::__construct($state);
        $this->configImport = $configImport;
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
     * @throws LocalizedException
     */
    protected function migrate(InputInterface $input, OutputInterface $output): int
    {
        $this->init($input, $output);
        $output->writeln('Importing configuration...');
        $this->configImport->importConfig();

        return Cli::RETURN_SUCCESS;
    }
}
