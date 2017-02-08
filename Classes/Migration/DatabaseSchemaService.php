<?php
namespace KoninklijkeCollective\KoningPhinx\Migration;

use KoninklijkeCollective\KoningPhinx\Utility\ConfigurationUtility;

/**
 * SchemaService: Phinx Database
 *
 * @package KoninklijkeCollective\KoningPhinx\Migration
 */
class DatabaseSchemaService implements \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * @var string
     */
    protected $migrationTableQuery;

    /**
     * @param array $sqlString
     * @param string $extensionKey
     * @return array
     */
    public function addPhinxRequiredDatabaseSchemaForInstallUtility(array $sqlString, $extensionKey)
    {
        $sqlString[] = $this->getPhinxRequiredDatabaseSchema();
        return [$sqlString, $extensionKey];
    }

    /**
     * @param array $sqlString
     * @return array
     */
    public function addPhinxRequiredDatabaseSchemaForSqlExpectedSchemaService(array $sqlString)
    {
        $sqlString[] = $this->getPhinxRequiredDatabaseSchema();
        return [$sqlString];
    }

    /**
     * @return string
     */
    protected function getPhinxRequiredDatabaseSchema()
    {
        return "CREATE TABLE `" . ConfigurationUtility::getMigrationTable() . "` (
  `version` bigint(20) NOT NULL default NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT 'CURRENT_TIMESTAMP' on update CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`version`)
);";
    }
}
