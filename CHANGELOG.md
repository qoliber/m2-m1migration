# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.1] - 2024

### Added
- Comprehensive Magento 1 to Magento 2 data migration tool via console commands
- Master command `qoliber:import:full` for complete migration workflow automation
- Granular migration commands for individual entity types:
  - `qoliber:import:catalog` - Product catalog migration
  - `qoliber:import:cms:blocks` - CMS blocks migration
  - `qoliber:import:cms:pages` - CMS pages migration
  - `qoliber:import:config` - Core configuration migration
  - `qoliber:import:customer` - Customer accounts migration
  - `qoliber:import:email-templates` - Email template migration
  - `qoliber:import:gallery` - Product image gallery migration
  - `qoliber:import:reviews` - Product reviews migration
  - `qoliber:import:sales` - Sales orders migration
  - `qoliber:import:sales:creditmemo` - Credit memos migration
  - `qoliber:import:sales:invoices` - Invoices migration
  - `qoliber:import:sales:rules` - Shopping cart price rules migration
  - `qoliber:import:shipment` - Shipment data migration
  - `qoliber:import:stock` - Inventory/stock migration
  - `qoliber:import:stores` - Multi-store configuration migration
  - `qoliber:import:subscribers` - Newsletter subscribers migration
  - `qoliber:import:tax` - Tax rules and rates migration
- Delta mode support via `--delta` (`-d`) flag for incremental updates without full reimport
- Abstract migration class `MigrationAbstract` providing common functionality
- Automatic area code initialization to `AREA_ADMINHTML` for proper entity handling
- Full migration workflow executing in logical order:
  1. Website configuration
  2. Store groups configuration
  3. Store views configuration
  4. Core configuration settings
  5. Tax rules and rates
  6. EAV attribute matching
  7. Sequence table recreation (skipped in delta mode)
  8. Customer accounts and addresses sync with status updates
  9. Sales orders, invoices, and credit memos sync
  10. Catalog import
  11. Stock/inventory sync
  12. CMS blocks and pages sync

### Changed
- EAV attributes matched between M1 and M2 schemas before migration
- Sequence tables recreated for proper entity ID generation (full mode only)
- Customer and address sync includes status updates for tracking

### Technical Details
- All migration commands extend `MigrationAbstract` base class
- Uses direct database queries for performance (Zend_Db)
- Implements `InputInterface` and `OutputInterface` for console interaction
- Error handling with exception catching and trace output
- Returns `Cli::RETURN_SUCCESS` or `Cli::RETURN_FAILURE` status codes
- Requires `magento/framework` 103.0.* and PHP >=7.4
- Import models handle actual data transformation and persistence
- Support for both full and delta synchronization strategies
- Area code management prevents "Area code not set" exceptions during migration
