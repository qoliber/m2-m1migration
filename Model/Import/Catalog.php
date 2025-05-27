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

use Exception;
use Magento\Framework\Event\Manager as EventManager;
use Magento\Framework\Exception\LocalizedException;
use Qoliber\MigrationTool\Helper\Import\PriceFixer;
use Qoliber\MigrationTool\Helper\Import\ScopeFixer;
use Qoliber\MigrationTool\Helper\Import\StatusFixer;
use Qoliber\MigrationTool\Model\Import\Entities\CategorySync;
use Qoliber\MigrationTool\Model\Import\Entities\ProductSync;
use Qoliber\MigrationTool\Model\Import\Entities\ReviewSync;
use Qoliber\MigrationTool\Model\Import\Entities\StockSync;
use Qoliber\MigrationTool\Model\Import\Setup\EavAttributes;
use Qoliber\MigrationTool\Model\UrlRewrite\Fixer as UrlFixer;
use Symfony\Component\Console\Output\ConsoleOutput;
use Zend_Db_Adapter_Exception;
use Zend_Db_Exception;
use Zend_Db_Statement_Exception;
use Zend_Db_Statement_Mysqli_Exception;

class Catalog
{
    private CategorySync $category;

    private ProductSync $product;

    private StatusFixer $statusFixer;

    private UrlFixer $fixer;

    private PriceFixer $priceFixer;

    private ScopeFixer $scopeFixer;

    private ReviewSync $reviews;

    private EavValuesSync $valuesSync;

    private GallerySync $gallerySync;

    private GalleryValueSync $galleryValueSync;

    private RelationsSync $relationsSync;

    private ConsoleOutput $output;

    private StockSync $stockSync;

    private EavAttributes $eavAttributes;

    private EventManager $eventManager;

    /**
     * @param CategorySync $category
     * @param ProductSync $product
     * @param GallerySync $gallerySync
     * @param GalleryValueSync $galleryValueSync
     * @param StatusFixer $statusFixer
     * @param UrlFixer $fixer
     * @param PriceFixer $priceFixer
     * @param ScopeFixer $scopeFixer
     * @param ReviewSync $reviews
     * @param EavValuesSync $valuesSync
     * @param RelationsSync $relationsSync
     * @param ConsoleOutput $output
     * @param StockSync $stockSync
     * @param EavAttributes $eavAttributes
     * @param EventManager $eventManager
     */
    public function __construct(
        CategorySync $category,
        ProductSync $product,
        GallerySync $gallerySync,
        GalleryValueSync $galleryValueSync,
        StatusFixer $statusFixer,
        UrlFixer $fixer,
        PriceFixer $priceFixer,
        ScopeFixer $scopeFixer,
        ReviewSync $reviews,
        EavValuesSync $valuesSync,
        RelationsSync $relationsSync,
        ConsoleOutput $output,
        StockSync $stockSync,
        EavAttributes $eavAttributes,
        EventManager $eventManager
    ) {
        $this->category = $category;
        $this->product = $product;
        $this->statusFixer = $statusFixer;
        $this->fixer = $fixer;
        $this->priceFixer = $priceFixer;
        $this->scopeFixer = $scopeFixer;
        $this->reviews = $reviews;
        $this->valuesSync = $valuesSync;
        $this->gallerySync = $gallerySync;
        $this->galleryValueSync = $galleryValueSync;
        $this->relationsSync = $relationsSync;
        $this->output = $output;
        $this->stockSync = $stockSync;
        $this->eavAttributes = $eavAttributes;
        $this->eventManager = $eventManager;
    }


    /**
     * @param bool $delta
     * @throws LocalizedException|Zend_Db_Adapter_Exception|Zend_Db_Exception|Zend_Db_Statement_Exception|Zend_Db_Statement_Mysqli_Exception|Exception
     */
    public function importCatalog(bool $delta = false) : void
    {
        $this->output->writeln('<info>Importing catalog attributes...</info>');
        $this->eavAttributes->matchEavAttributes();


        $this->output->writeln('<info>Importing categories...</info>');
        $this->category->sync();
        $this->output->writeln('<info>Importing products...</info>');
        $this->product->sync();
        $this->output->writeln('<info>Importing EAV data...</info>');
        $this->valuesSync->setEntities([3, 4])->sync();

        $this->output->writeln('<info>Importing stock data...</info>');
        $this->stockSync->sync();

        $this->output->writeln('<info>Importing gallery...</info>');
        $this->gallerySync->sync();
        $this->galleryValueSync->sync();
        $this->output->writeln('<info>Importing product relations...</info>');
        $this->relationsSync->sync();
        $this->output->writeln('<info>Running price fixer...</info>');
        $this->priceFixer->fixPrices();
        $this->output->writeln('<info>Running status fixer...</info>');
        $this->statusFixer->fixStatus();
        $this->output->writeln('<info>Running attribute scopes fixer...</info>');
        $this->scopeFixer->fixScopes();
        $this->output->writeln('<info>(Re)generating URLs for default store...</info>');
        $this->fixer->fixUrlsForStore();
        $this->output->writeln('<info>Importing reviews...</info>');
        $this->reviews->sync();

        $this->eventManager->dispatch('Qoliber_catalog_import_after');
    }
}
