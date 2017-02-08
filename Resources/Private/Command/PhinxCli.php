<?php
use KoninklijkeCollective\KoningPhinx\Input\PhinxInput;
use Phinx\Console\PhinxApplication;

/**
 * Invoke CLI command
 *
 * @usage php typo3/cli_dispatch.phpsh koning_phinx
 */
call_user_func(function () {
    $input = new PhinxInput();

    $app = new PhinxApplication();
    $app->run($input);
});
