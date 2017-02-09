<?php
namespace KoninklijkeCollective\KoningPhinx\Input;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Input: Phinx
 *
 * @package KoninklijkeCollective\KoningPhinx\Input
 */
class PhinxInput extends \Symfony\Component\Console\Input\ArgvInput
{

    /**
     * Get fixed extension options or return default input for phinx mapping
     *
     * @param string $name
     * @return string
     */
    public function getOption($name)
    {
        switch ($name) {
            case 'configuration':
                return GeneralUtility::getFileAbsFileName('EXT:koning_phinx/Resources/Private/Configuration/PhinxConfiguration.php');
            case 'environment':
                return 'typo3';
            default;
                return parent::getOption($name);
        }
    }

    /**
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getFirstArgument() {
        $firstArgument = parent::getFirstArgument();

        if ($firstArgument === 'init') {
            throw new \InvalidArgumentException('Init is stopped due to invoke via TYPO3, configure via ExtensionManager.', 1486632696779);
        }

        return $firstArgument;
    }
}
