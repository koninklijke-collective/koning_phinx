# TYPO3 Extension: Phinx Integration
  * Description: Phinx.org integration for Database Migrations
  * Extension key: koning_phinx
  * TER: http://typo3.org/extensions/repository/view/koning_phinx


Howto
-----
Configure the extension as you would like; like example below:
 
```php
    $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['koning_phinx'] = [
        // Define paths outside PATH_site root
        'path_migrations' => '../database/migrations',
        'path_seeds' => '../database/seeds',
        // Enable extension migrations/seeds:Careful, this enables extension migrations! All enabled extensions with EXT:extension/Phinx/{Migrations,Seeds} directories.
        'include_extension_directories' => true,
    ];
```

Usage
-----
You can use all the Phinx features with the following command;

```bash
    # Get all options
    php typo3/cli_dispatch.phpsh koning_phinx list
    
    # Invoke migrations
    php typo3/cli_dispatch.phpsh koning_phinx migrate
    
    # Create migration
    php typo3/cli_dispatch.phpsh koning_phinx create SpecifyYourSpecificChangeAsTitle
    
    # Display status of all migrations
    php typo3/cli_dispatch.phpsh koning_phinx status
    
    # Invoke seeds
    php typo3/cli_dispatch.phpsh koning_phinx seed:run
    
    # Create seed
    php typo3/cli_dispatch.phpsh koning_phinx seed:create YourSeedTitle
```
