<?php
namespace KoninklijkeCollective\KoningPhinx\Utility;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;

/**
 * Utility: Phinx Configuration
 *
 * @package KoninklijkeCollective\KoningPhinx\Utility
 */
class ConfigurationUtility
{

    /**
     * Configure paths for Phinx
     *
     * @return array
     */
    public static function getPaths()
    {
        list ($migrations, $seeds) = (self::includeExtensionDirectories() ? self::getExtensionDatabasePaths() : []);
        return [
            'migrations' => (!empty($migrations)
                ? '{' . self::getMigrationsPath() . ',' . implode(',', $migrations) . '}'
                : self::getMigrationsPath()),
            'seeds' => (!empty($seeds)
                ? '{' . self::getSeedsPath() . ',' . implode(',', $seeds) . '}'
                : self::getSeedsPath()),
        ];
    }

    /**
     * Get all possible extension paths for Phinx Migrations/Seeds
     *
     * @param array $migrations
     * @param array $seeds
     * @return array
     */
    protected static function getExtensionDatabasePaths($migrations = [], $seeds = [])
    {
        foreach (ExtensionManagementUtility::getLoadedExtensionListArray() as $extension) {
            $extensionPath = ExtensionManagementUtility::extPath($extension) . 'Phinx/';
            if (is_dir($extensionPath . 'Migrations')) {
                $migrations[] = $extensionPath . 'Migrations';
            }
            if (is_dir($extensionPath . 'Seeds')) {
                $seeds[] = $extensionPath . 'Seeds';
            }
        }
        return [$migrations, $seeds];
    }

    /**
     * @return boolean
     */
    public static function includeExtensionDirectories()
    {
        $configuration = self::getConfiguration();
        if (isset($configuration['include_extension_directories'])) {
            return (bool)$configuration['include_extension_directories'];
        }
        return false;
    }

    /**
     * @return string
     */
    public static function getMigrationsPath()
    {
        $configuration = self::getConfiguration();
        $path = null;
        if (!empty($configuration['path_migrations'])) {
            $path = self::getDirectoryAbsoluteName($configuration['path_migrations']);
        }
        return $path ?: PATH_site . 'Database/Migrations';
    }

    /**
     * @return string
     */
    public static function getSeedsPath()
    {
        $configuration = self::getConfiguration();
        $path = null;
        if (!empty($configuration['path_seeds'])) {
            $path = self::getDirectoryAbsoluteName($configuration['path_seeds']);
        }
        return $path ?: PATH_site . 'Database/Seeds';
    }

    /**
     * @return string
     */
    public static function getMigrationTable()
    {
        $configuration = self::getConfiguration();
        return $configuration['migration_table'] ?: 'phinxlog';
    }

    /**
     * @return array
     */
    public static function getDatabaseConfiguration()
    {
        return [
            'adapter' => 'mysql',
            'name' => TYPO3_db,
            'host' => TYPO3_db_host,
            'user' => TYPO3_db_username,
            'pass' => TYPO3_db_password,
            'port' => isset($GLOBALS['TYPO3_CONF_VARS']['DB']['port']) ? $GLOBALS['TYPO3_CONF_VARS']['DB']['port'] : 3306,
            'charset' => 'utf8'
        ];
    }

    /**
     * Get absolute directory (allows EXT:<extension>)
     *
     * @param string $directory
     * @return string
     */
    protected function getDirectoryAbsoluteName($directory)
    {
        if ((string)$directory === '') {
            return '';
        }

        // EXT: functionality
        if (StringUtility::beginsWith($directory, 'EXT:')) {
            list($extension, $directoryPath) = explode('/', substr($directory, 4), 2);
            $directory = '';
            if ((string)$extension !== '' && ExtensionManagementUtility::isLoaded($extension) && (string)$directoryPath !== '') {
                $directory = ExtensionManagementUtility::extPath($extension) . $directoryPath;
            }
        } elseif (GeneralUtility::isAbsPath($directory) === false || !is_dir($directory)) {
            $directory = realpath(PATH_site . $directory);
        }
        if ((string)$directory !== '' && GeneralUtility::validPathStr($directory)) {
            // checks backpath.
            return $directory;
        }
        return '';
    }

    /**
     * Get Global Configuration from ExtensionManager setup:
     *
     * @see ext_conf_template.txt
     * @return array
     */
    public static function getConfiguration()
    {
        static $configuration;
        if ($configuration === null) {
            $data = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['koning_phinx'];
            if (!is_array($data)) {
                $configuration = (array)unserialize($data);
            } else {
                $configuration = $data;
            }
        }
        return $configuration;
    }
}
