<?php
defined('TYPO3_MODE') or die('Access denied.');

call_user_func(function ($extension) {
    // Add TYPO3 Phinx integration
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['GLOBAL']['cliKeys'][$extension] = [
        'EXT:' . $extension . '/Resources/Private/Command/PhinxCli.php',
        '_CLI_lowlevel'
    ];

    // Make sure table is not adjusted via install tool/database compare
    $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
    $signalSlotDispatcher->connect(
        \TYPO3\CMS\Install\Service\SqlExpectedSchemaService::class,
        'tablesDefinitionIsBeingBuilt',
        \KoninklijkeCollective\KoningPhinx\Migration\DatabaseSchemaService::class,
        'addPhinxRequiredDatabaseSchemaForSqlExpectedSchemaService'
    );

    $signalSlotDispatcher->connect(
        \TYPO3\CMS\Extensionmanager\Utility\InstallUtility::class,
        'tablesDefinitionIsBeingBuilt',
        \KoninklijkeCollective\KoningPhinx\Migration\DatabaseSchemaService::class,
        'addPhinxRequiredDatabaseSchemaForInstallUtility'
    );
}, $_EXTKEY);
