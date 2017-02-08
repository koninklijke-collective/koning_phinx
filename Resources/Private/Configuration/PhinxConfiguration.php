<?php
/**
 * Phinx: Command Line Interface module dispatcher
 */
use KoninklijkeCollective\KoningPhinx\Utility\ConfigurationUtility;

// Return application logic for TYPO3
return call_user_func(function () {
    return [
        'paths' => ConfigurationUtility::getPaths(),
        'environments' => [
            'default_migration_table' => ConfigurationUtility::getMigrationTable(),
            'default_database' => 'typo3',
            'typo3' => ConfigurationUtility::getDatabaseConfiguration(),
        ],
    ];
});
